<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, BelongsToTeam;

    protected $fillable = [
        'team_id',
        'assigned_to_id',
        'created_by_id',
        'related_to_type',
        'related_to_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'start_date',
        'reminder_at',
        'reminder_sent',
        'is_completed',
        'completed_at',
        'completed_by_id',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_interval',
        'recurrence_days',
        'recurrence_ends_at',
        'parent_task_id',
        'is_private',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime',
        'reminder_at' => 'datetime',
        'reminder_sent' => 'boolean',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'is_recurring' => 'boolean',
        'recurrence_interval' => 'integer',
        'recurrence_days' => 'array',
        'recurrence_ends_at' => 'datetime',
        'is_private' => 'boolean',
    ];

    protected $appends = ['is_overdue', 'is_today', 'priority_color'];

    // Relationships
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by_id');
    }

    public function relatedTo(): MorphTo
    {
        return $this->morphTo();
    }

    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    // Accessors
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date 
            && $this->due_date->isPast() 
            && !$this->is_completed;
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->due_date 
            && $this->due_date->isToday() 
            && !$this->is_completed;
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'normal' => 'blue',
            'low' => 'gray',
            default => 'gray',
        };
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('is_completed', false);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today())
            ->where('is_completed', false);
    }

    public function scopeDueSoon($query, int $days = 7)
    {
        return $query->whereBetween('due_date', [now(), now()->addDays($days)])
            ->where('is_completed', false);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    public function scopeAssignedTo($query, User $user)
    {
        return $query->where('assigned_to_id', $user->id);
    }

    // Methods
    public function complete(User $user = null): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
            'completed_by_id' => $user?->id ?? auth()->id(),
            'status' => 'completed',
        ]);

        // Create activity
        if ($this->relatedTo) {
            $this->relatedTo->recordActivity('task_completed', [
                'description' => "Task completed: {$this->title}",
                'metadata' => ['task_id' => $this->id],
            ]);
        }

        // Create next recurring task if applicable
        if ($this->is_recurring) {
            $this->createNextRecurrence();
        }
    }

    public function uncomplete(): void
    {
        $this->update([
            'is_completed' => false,
            'completed_at' => null,
            'completed_by_id' => null,
            'status' => 'in_progress',
        ]);
    }

    public function sendReminder(): void
    {
        // Send notification to assigned user
        $this->assignedTo->notify(new \App\Notifications\TaskReminderNotification($this));

        $this->update(['reminder_sent' => true]);
    }

    private function createNextRecurrence(): void
    {
        if (!$this->is_recurring || !$this->due_date) {
            return;
        }

        $nextDueDate = match($this->recurrence_pattern) {
            'daily' => $this->due_date->addDays($this->recurrence_interval ?? 1),
            'weekly' => $this->due_date->addWeeks($this->recurrence_interval ?? 1),
            'monthly' => $this->due_date->addMonths($this->recurrence_interval ?? 1),
            'yearly' => $this->due_date->addYears($this->recurrence_interval ?? 1),
            default => null,
        };

        if (!$nextDueDate || ($this->recurrence_ends_at && $nextDueDate->isAfter($this->recurrence_ends_at))) {
            return;
        }

        Task::create([
            'assigned_to_id' => $this->assigned_to_id,
            'created_by_id' => $this->created_by_id,
            'related_to_type' => $this->related_to_type,
            'related_to_id' => $this->related_to_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $nextDueDate,
            'is_recurring' => true,
            'recurrence_pattern' => $this->recurrence_pattern,
            'recurrence_interval' => $this->recurrence_interval,
            'recurrence_days' => $this->recurrence_days,
            'recurrence_ends_at' => $this->recurrence_ends_at,
            'parent_task_id' => $this->id,
        ]);
    }

    public static function getPriorityOptions(): array
    {
        return [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'not_started' => 'Not Started',
            'in_progress' => 'In Progress',
            'waiting_on_someone' => 'Waiting on Someone',
            'completed' => 'Completed',
            'deferred' => 'Deferred',
            'cancelled' => 'Cancelled',
        ];
    }
}