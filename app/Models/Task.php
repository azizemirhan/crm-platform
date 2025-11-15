<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

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
        'completed_at' => 'datetime',
        'recurrence_ends_at' => 'datetime',
        'reminder_sent' => 'boolean',
        'is_completed' => 'boolean',
        'is_recurring' => 'boolean',
        'is_private' => 'boolean',
        'recurrence_days' => 'array',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by_id');
    }

    public function relatedTo()
    {
        return $this->morphTo();
    }

    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }
}