<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'meeting_type',
        'meeting_link',
        'status',
        'priority',
        'contact_id',
        'lead_id',
        'opportunity_id',
        'owner_id',
        'notes',
        'outcome',
        'attendees',
        'reminder_sent',
        'reminder_minutes_before',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'attendees' => 'array',
        'reminder_sent' => 'boolean',
    ];

    // Relationships
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>=', now())
                    ->where('status', 'scheduled')
                    ->orderBy('start_time');
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', now())
                    ->orderBy('start_time', 'desc');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('start_time', today())
                    ->orderBy('start_time');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('start_time', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->orderBy('start_time');
    }

    // Accessors
    public function getDurationAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return null;
        }

        return $this->start_time->diffInMinutes($this->end_time);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->start_time && $this->start_time->isFuture();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'scheduled' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'rescheduled' => 'warning',
            default => 'secondary'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'secondary'
        };
    }

    // Methods
    public function markAsCompleted(string $outcome = null)
    {
        $this->update([
            'status' => 'completed',
            'outcome' => $outcome ?? $this->outcome
        ]);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function reschedule($startTime, $endTime)
    {
        $this->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'rescheduled'
        ]);
    }
}
