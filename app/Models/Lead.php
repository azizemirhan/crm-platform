<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\HasActivities;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Lead extends Model implements Auditable
{
    use HasFactory,
        SoftDeletes,
        BelongsToTeam,
        HasOwner,
        HasActivities,
        \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'team_id',
        'owner_id',
        'converted_contact_id',
        'converted_account_id',
        'converted_opportunity_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'title',
        'website',
        'source',
        'source_metadata',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'referring_url',
        'landing_page',
        'ip_address',
        'message',
        'industry',
        'company_size',
        'budget',
        'currency',
        'expected_close_date',
        'status',
        'score',
        'rating',
        'disqualification_reason',
        'converted_at',
        'qualified_at',
        'first_contacted_at',
    ];

    protected $casts = [
        'source_metadata' => 'array',
        'budget' => 'decimal:2',
        'expected_close_date' => 'date',
        'converted_at' => 'datetime',
        'qualified_at' => 'datetime',
        'first_contacted_at' => 'datetime',
        'score' => 'integer',
    ];

    protected $appends = ['full_name', 'days_since_created'];

    // Relationships
    public function convertedContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'converted_contact_id');
    }

    public function convertedAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'converted_account_id');
    }

    public function convertedOpportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class, 'converted_opportunity_id');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getDaysSinceCreatedAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getIsConvertedAttribute(): bool
    {
        return $this->status === 'converted' && $this->converted_contact_id !== null;
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeQualified($query)
    {
        return $query->where('status', 'qualified');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }

    public function scopeHotLeads($query)
    {
        return $query->where('rating', 'hot');
    }

    public function scopeHighScore($query, int $minScore = 70)
    {
        return $query->where('score', '>=', $minScore);
    }

    public function scopeUncontacted($query)
    {
        return $query->whereNull('first_contacted_at')
            ->where('status', 'new');
    }

    // Methods
    public function qualify(): void
    {
        $this->update([
            'status' => 'qualified',
            'qualified_at' => now(),
        ]);

        $this->recordActivity('lead_status_change', [
            'description' => 'Lead qualified',
            'metadata' => ['old_status' => 'new', 'new_status' => 'qualified'],
        ]);
    }

    public function disqualify(string $reason): void
    {
        $this->update([
            'status' => 'unqualified',
            'disqualification_reason' => $reason,
        ]);

        $this->recordActivity('lead_status_change', [
            'description' => "Lead disqualified: {$reason}",
            'metadata' => ['reason' => $reason],
        ]);
    }

    public function convert(bool $createAccount = true, bool $createOpportunity = true): array
    {
        // Create Contact
        $contact = Contact::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'title' => $this->title,
            'lead_source' => $this->source,
            'lead_source_description' => $this->source_metadata['campaign_name'] ?? null,
            'description' => $this->message,
        ]);

        $results = ['contact' => $contact];

        // Create Account (optional)
        if ($createAccount && $this->company) {
            $account = Account::create([
                'name' => $this->company,
                'website' => $this->website,
                'industry' => $this->industry,
                'size' => $this->company_size,
                'source' => $this->source,
            ]);

            $contact->update(['account_id' => $account->id]);
            $results['account'] = $account;
        }

        // Create Opportunity (optional)
        if ($createOpportunity && $this->budget) {
            $opportunity = Opportunity::create([
                'contact_id' => $contact->id,
                'account_id' => $results['account']->id ?? null,
                'name' => "Opportunity from {$this->full_name}",
                'amount' => $this->budget,
                'currency' => $this->currency,
                'expected_close_date' => $this->expected_close_date,
                'stage' => 'prospecting',
                'lead_source' => $this->source,
                'lead_id' => $this->id,
            ]);

            $results['opportunity'] = $opportunity;
        }

        // Update lead
        $this->update([
            'status' => 'converted',
            'converted_contact_id' => $contact->id,
            'converted_account_id' => $results['account']->id ?? null,
            'converted_opportunity_id' => $results['opportunity']->id ?? null,
            'converted_at' => now(),
        ]);

        $this->recordActivity('lead_status_change', [
            'description' => 'Lead converted to contact' . 
                ($createAccount ? ' and account' : '') . 
                ($createOpportunity ? ' and opportunity' : ''),
        ]);

        return $results;
    }

    public function calculateScore(): int
    {
        $score = 0;

        // Email domain quality
        if ($this->email) {
            $domain = explode('@', $this->email)[1] ?? '';
            if (!in_array($domain, ['gmail.com', 'hotmail.com', 'yahoo.com'])) {
                $score += 10; // Business email
            }
        }

        // Has company
        if ($this->company) {
            $score += 15;
        }

        // Has budget
        if ($this->budget && $this->budget > 0) {
            $score += 20;
        }

        // Source quality
        $sourceScores = [
            'google_ads' => 15,
            'referral' => 25,
            'linkedin' => 20,
            'web_form' => 10,
            'cold_call' => 5,
        ];
        $score += $sourceScores[$this->source] ?? 0;

        // Company size
        $sizeScores = [
            '1-10' => 5,
            '11-50' => 10,
            '51-200' => 15,
            '201-500' => 20,
            '501+' => 25,
        ];
        $score += $sizeScores[$this->company_size] ?? 0;

        // Engagement (has been contacted)
        if ($this->first_contacted_at) {
            $score += 10;
        }

        return min($score, 100);
    }

    public function updateScore(): void
    {
        $this->update(['score' => $this->calculateScore()]);
    }
}