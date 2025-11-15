<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'subject_type',
        'subject_id',
        'user_id',
        'type',
        'direction',
        'status',
        'title',
        'description',
        'scheduled_at',
        'started_at',
        'completed_at',
        'duration',
        'from',
        'to',
        'cc',
        'bcc',
        'call_sid',
        'call_status',
        'recording_url',
        'call_duration',
        'email_message_id',
        'email_opened',
        'email_open_count',
        'email_first_opened_at',
        'email_last_opened_at',
        'email_clicked',
        'email_click_count',
        'email_first_clicked_at',
        'email_bounced',
        'email_bounce_reason',
        'message_sid',
        'message_status',
        'location',
        'attendees',
        'meeting_url',
        'all_day',
        'metadata',
        'is_private',
        'is_pinned',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'email_first_opened_at' => 'datetime',
        'email_last_opened_at' => 'datetime',
        'email_first_clicked_at' => 'datetime',
        'cc' => 'array',
        'bcc' => 'array',
        'attendees' => 'array',
        'metadata' => 'array',
        'email_opened' => 'boolean',
        'email_clicked' => 'boolean',
        'email_bounced' => 'boolean',
        'all_day' => 'boolean',
        'is_private' => 'boolean',
        'is_pinned' => 'boolean',
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

    public function subject()
    {
        return $this->morphTo();
    }
}