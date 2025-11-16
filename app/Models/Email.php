<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'message_id',
        'thread_id',
        'type',
        'subject',
        'body_html',
        'body_text',
        'from_email',
        'from_name',
        'to',
        'cc',
        'bcc',
        'reply_to',
        'is_read',
        'is_starred',
        'is_archived',
        'is_spam',
        'read_at',
        'sent_at',
        'related_to_type',
        'related_to_id',
        'attachments',
        'attachments_count',
        'attachments_size',
        'provider',
        'headers',
        'metadata',
    ];

    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'reply_to' => 'array',
        'attachments' => 'array',
        'headers' => 'array',
        'metadata' => 'array',
        'is_read' => 'boolean',
        'is_starred' => 'boolean',
        'is_archived' => 'boolean',
        'is_spam' => 'boolean',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
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
    public function scopeInbox($query)
    {
        return $query->where('type', 'inbox');
    }

    public function scopeSent($query)
    {
        return $query->where('type', 'sent');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function toggleStar()
    {
        $this->update(['is_starred' => !$this->is_starred]);
    }

    public function archive()
    {
        $this->update(['is_archived' => true]);
    }
}
