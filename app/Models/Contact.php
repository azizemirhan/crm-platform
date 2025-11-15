<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\HasActivities;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Contact extends Model implements Auditable
{
    use HasFactory,
        SoftDeletes,
        BelongsToTeam,
        HasOwner,
        HasActivities,
        \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'team_id',
        'account_id',
        'owner_id',
        'reports_to_id',
        'salutation',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'secondary_email',
        'phone',
        'mobile',
        'whatsapp',
        'fax',
        'title',
        'department',
        'birthdate',
        'linkedin_url',
        'mailing_street',
        'mailing_city',
        'mailing_state',
        'mailing_postal_code',
        'mailing_country',
        'lead_source',
        'lead_source_description',
        'status',
        'email_opt_out',
        'do_not_call',
        'sms_opt_out',
        'engagement_score',
        'last_contacted_at',
        'last_activity_at',
        'last_email_opened_at',
        'last_email_clicked_at',
        'description',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'birthdate' => 'date',
        'last_contacted_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'last_email_opened_at' => 'datetime',
        'last_email_clicked_at' => 'datetime',
        'email_opt_out' => 'boolean',
        'do_not_call' => 'boolean',
        'sms_opt_out' => 'boolean',
        'engagement_score' => 'integer',
    ];

    protected $appends = ['avatar_url'];

    // Relationships
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'reports_to_id');
    }

    public function directReports(): HasMany
    {
        return $this->hasMany(Contact::class, 'reports_to_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
    }

    public function convertedFromLead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'id', 'converted_contact_id');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // Accessors & Mutators
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("{$this->first_name} {$this->last_name}"),
        );
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->salutation 
                ? "{$this->salutation} {$this->full_name}"
                : $this->full_name,
        );
    }

    public function getAvatarUrlAttribute(): string
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeHighEngagement($query, int $minScore = 70)
    {
        return $query->where('engagement_score', '>=', $minScore);
    }

    public function scopeCanEmail($query)
    {
        return $query->where('email_opt_out', false)
            ->whereNotNull('email');
    }

    public function scopeCanCall($query)
    {
        return $query->where('do_not_call', false)
            ->whereNotNull('phone');
    }

    // Methods
    public function increaseEngagementScore(int $points = 5): void
    {
        $this->increment('engagement_score', min($points, 100 - $this->engagement_score));
    }

    public function decreaseEngagementScore(int $points = 5): void
    {
        $this->decrement('engagement_score', min($points, $this->engagement_score));
    }

    public function recordEmailOpened(): void
    {
        $this->update([
            'last_email_opened_at' => now(),
        ]);
        $this->increaseEngagementScore(5);
    }

    public function recordEmailClicked(): void
    {
        $this->update([
            'last_email_clicked_at' => now(),
        ]);
        $this->increaseEngagementScore(10);
    }

    public function canContact(string $method = 'email'): bool
    {
        return match($method) {
            'email' => !$this->email_opt_out && !empty($this->email),
            'phone', 'call' => !$this->do_not_call && !empty($this->phone),
            'sms', 'whatsapp' => !$this->sms_opt_out && !empty($this->mobile),
            default => false,
        };
    }
}