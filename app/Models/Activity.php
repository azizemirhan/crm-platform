<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes, BelongsToTeam;

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
        'duration' => 'integer',
        'cc' => 'array',
        'bcc' => 'array',
        'call_duration' => 'integer',
        'email_opened' => 'boolean',
        'email_open_count' => 'integer',
        'email_first_opened_at' => 'datetime',
        'email_last_opened_at' => 'datetime',
        'email_clicked' => 'boolean',
        'email_click_count' => 'integer',
        'email_first_clicked_at' => 'datetime',
        'email_bounced' => 'boolean',
        'attendees' => 'array',
        'all_day' => 'boolean',
        'metadata' => 'array',
        'is_private' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    protected $appends = ['icon', 'color'];

    // Relationships
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'call' => 'phone',
            'email' => 'envelope',
            'meeting' => 'calendar',
            'note' => 'sticky-note',
            'sms' => 'comment-sms',
            'whatsapp' => 'whatsapp',
            'task_completed' => 'check-circle',
            'opportunity_stage_change' => 'arrow-right',
            'lead_status_change' => 'exchange-alt',
            'file_upload' => 'file',
            'quote_sent' => 'file-invoice',
            'contract_signed' => 'file-signature',
            default => 'circle',
        };
    }

    public function getColorAttribute(): string
    {
        return match($this->type) {
            'call' => 'blue',
            'email' => 'green',
            'meeting' => 'purple',
            'note' => 'yellow',
            'sms', 'whatsapp' => 'teal',
            'task_completed' => 'emerald',
            'opportunity_stage_change', 'lead_status_change' => 'indigo',
            default => 'gray',
        };
    }

    public function getFormattedDurationAttribute(): ?string
    {
        if (!$this->duration) {
            return null;
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    // Scopes
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeCalls($query)
    {
        return $query->where('type', 'call');
    }

    public function scopeEmails($query)
    {
        return $query->where('type', 'email');
    }

    public function scopeMeetings($query)
    {
        return $query->where('type', 'meeting');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '>=', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query, int $days = 7)
    {
        return $query->where('status', 'scheduled')
            ->whereBetween('scheduled_at', [now(), now()->addDays($days)]);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    // Methods
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update subject's last_activity_at
        if ($this->subject && method_exists($this->subject, 'updateLastActivity')) {
            $this->subject->updateLastActivity();
        }
    }

    public function recordEmailOpen(): void
    {
        $updates = [
            'email_opened' => true,
            'email_open_count' => $this->email_open_count + 1,
            'email_last_opened_at' => now(),
        ];

        if (!$this->email_first_opened_at) {
            $updates['email_first_opened_at'] = now();
        }

        $this->update($updates);

        // Update contact engagement
        if ($this->subject_type === Contact::class && $this->subject) {
            $this->subject->recordEmailOpened();
        }
    }

    public function recordEmailClick(): void
    {
        $updates = [
            'email_clicked' => true,
            'email_click_count' => $this->email_click_count + 1,
        ];

        if (!$this->email_first_clicked_at) {
            $updates['email_first_clicked_at'] = now();
        }

        $this->update($updates);

        // Update contact engagement
        if ($this->subject_type === Contact::class && $this->subject) {
            $this->subject->recordEmailClicked();
        }
    }

    public static function getTypeOptions(): array
    {
        return [
            'call' => 'Call',
            'email' => 'Email',
            'meeting' => 'Meeting',
            'note' => 'Note',
            'sms' => 'SMS',
            'whatsapp' => 'WhatsApp',
            'task_completed' => 'Task Completed',
        ];
    }
}