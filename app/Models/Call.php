<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Call extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'call_sid',
        'direction',
        'type',
        'from_number',
        'to_number',
        'from_name',
        'to_name',
        'status',
        'disposition',
        'started_at',
        'answered_at',
        'ended_at',
        'duration',
        'billable_duration',
        'recording_url',
        'recording_sid',
        'recording_duration',
        'is_recorded',
        'related_to_type',
        'related_to_id',
        'notes',
        'summary',
        'tags',
        'cost',
        'cost_unit',
        'twilio_data',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'answered_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_recorded' => 'boolean',
        'tags' => 'array',
        'twilio_data' => 'array',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function related_to()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeMissed($query)
    {
        return $query->where('disposition', 'no-answer');
    }

    // Methods
    public function isAnswered()
    {
        return $this->disposition === 'answered';
    }

    public function formatDuration()
    {
        if ($this->duration < 60) {
            return $this->duration . 's';
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return "{$minutes}m {$seconds}s";
    }
}
