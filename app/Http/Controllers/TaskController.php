<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $contacts = Contact::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->full_name
                ];
            });

        return view('tasks.index', compact('users', 'contacts'));
    }

    public function getTasks(Request $request)
    {
        $query = Task::with(['assignedUser', 'taskable']);

        // Apply filters
        if ($request->has('assigned_to') && $request->assigned_to) {
            $query->where('assigned_to_id', $request->assigned_to);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderBy('order')->get();

        // Group tasks by status
        $tasksByStatus = [
            'todo' => [],
            'in_progress' => [],
            'in_review' => [],
            'completed' => [],
        ];

        foreach ($tasks as $task) {
            $status = $task->status ?? 'todo';
            if (isset($tasksByStatus[$status])) {
                $tasksByStatus[$status][] = $this->formatTask($task);
            }
        }

        return response()->json($tasksByStatus);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,in_review,completed',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'assigned_to_id' => 'nullable|exists:users,id',
            'taskable_type' => 'nullable|string',
            'taskable_id' => 'nullable|integer',
        ]);

        $validated['team_id'] = auth()->user()->current_team_id ?? 1;
        $validated['created_by_id'] = auth()->id();
        $validated['order'] = Task::where('status', $validated['status'])->max('order') + 1;

        $task = Task::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Görev başarıyla oluşturuldu.',
            'task' => $this->formatTask($task->fresh(['assignedUser', 'taskable']))
        ]);
    }

    public function show(Task $task)
    {
        $task->load(['assignedUser', 'taskable']);
        return response()->json($this->formatTask($task));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,in_review,completed',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'assigned_to_id' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Görev başarıyla güncellendi.',
            'task' => $this->formatTask($task->fresh(['assignedUser', 'taskable']))
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,in_review,completed',
            'order' => 'required|integer|min:0',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Görev durumu güncellendi.'
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:tasks,id',
            'tasks.*.order' => 'required|integer|min:0',
            'tasks.*.status' => 'required|in:todo,in_progress,in_review,completed',
        ]);

        foreach ($validated['tasks'] as $taskData) {
            Task::where('id', $taskData['id'])->update([
                'order' => $taskData['order'],
                'status' => $taskData['status'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Görevler yeniden sıralandı.'
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Görev silindi.'
        ]);
    }

    public function complete(Task $task)
    {
        $task->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Görev tamamlandı olarak işaretlendi.'
        ]);
    }

    public function uncomplete(Task $task)
    {
        $task->update(['status' => 'todo']);

        return response()->json([
            'success' => true,
            'message' => 'Görev yapılacak olarak işaretlendi.'
        ]);
    }

    private function formatTask(Task $task)
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date?->format('Y-m-d'),
            'due_date_human' => $task->due_date?->format('d M Y'),
            'is_overdue' => $task->due_date && $task->due_date->isPast() && $task->status !== 'completed',
            'assigned_to_id' => $task->assigned_to_id,
            'assigned_to' => $task->assignedUser ? [
                'id' => $task->assignedUser->id,
                'name' => $task->assignedUser->name,
                'initials' => $this->getInitials($task->assignedUser->name),
            ] : null,
            'taskable_type' => $task->taskable_type,
            'taskable_id' => $task->taskable_id,
            'taskable_name' => $this->getTaskableName($task),
            'order' => $task->order ?? 0,
        ];
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    private function getTaskableName(Task $task)
    {
        if (!$task->taskable) {
            return null;
        }

        if ($task->taskable_type === 'App\\Models\\Contact') {
            return $task->taskable->full_name ?? $task->taskable->name;
        }

        return $task->taskable->name ?? $task->taskable->title ?? null;
    }
}
