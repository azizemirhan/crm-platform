<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $contacts = Contact::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->full_name
                ];
            });

        $users = User::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('meetings.index', compact('contacts', 'users'));
    }

    public function getEvents(Request $request)
    {
        $query = Meeting::with(['contact', 'owner']);

        // Apply filters
        if ($request->has('contact_id') && $request->contact_id) {
            $query->where('contact_id', $request->contact_id);
        }

        if ($request->has('owner_id') && $request->owner_id) {
            $query->where('owner_id', $request->owner_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('meeting_type') && $request->meeting_type) {
            $query->where('meeting_type', $request->meeting_type);
        }

        // Date range for FullCalendar
        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('start_time', [$request->start, $request->end]);
        }

        $meetings = $query->get();

        // Format for FullCalendar
        $events = $meetings->map(function ($meeting) {
            return [
                'id' => $meeting->id,
                'title' => $meeting->title,
                'start' => $meeting->start_time->format('Y-m-d H:i:s'),
                'end' => $meeting->end_time->format('Y-m-d H:i:s'),
                'backgroundColor' => $this->getEventColor($meeting),
                'borderColor' => $this->getEventColor($meeting),
                'extendedProps' => [
                    'description' => $meeting->description,
                    'location' => $meeting->location,
                    'meeting_type' => $meeting->meeting_type,
                    'meeting_link' => $meeting->meeting_link,
                    'priority' => $meeting->priority,
                    'status' => $meeting->status,
                    'contact' => $meeting->contact ? $meeting->contact->full_name : null,
                    'contact_id' => $meeting->contact_id,
                    'owner' => $meeting->owner ? $meeting->owner->name : null,
                    'owner_id' => $meeting->owner_id,
                ],
            ];
        });

        return response()->json($events);
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['contact', 'owner']);
        return response()->json($meeting);
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'meeting_type' => 'required|in:in_person,online,phone',
            'meeting_link' => 'nullable|url',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
            'contact_id' => 'nullable|exists:contacts,id',
        ]);

        $meeting->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Toplantı başarıyla güncellendi.',
            'meeting' => $meeting->fresh(['contact', 'owner'])
        ]);
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return response()->json([
            'success' => true,
            'message' => 'Toplantı silindi.'
        ]);
    }

    private function getEventColor(Meeting $meeting)
    {
        // Color based on priority and status
        if ($meeting->status === 'cancelled') {
            return '#6c757d';
        }

        if ($meeting->status === 'completed') {
            return '#28a745';
        }

        return match($meeting->priority) {
            'high' => '#dc3545',
            'medium' => '#ffc107',
            'low' => '#17a2b8',
            default => '#007bff'
        };
    }
}
