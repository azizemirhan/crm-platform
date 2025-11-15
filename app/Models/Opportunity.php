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

class Opportunity extends Model implements Auditable
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
        'contact_id',
        'owner_id',
        'lead_id',
        'name',
        'amount',
        'currency',
        'stage',
        'probability',
        'expected_close_date',
        'actual_close_date',
        'type',
        'lead_source',
        'outcome',
        'won_reason',
        'loss_reason',
        'competitor_lost_to',
        'cost_of_sale',
        'recurring_revenue',
        'billing_frequency',
        'is_private',
        'forecast_category',
        'description',
        'next_steps',
        'custom_fields',
        'last_activity_at',
        'days_in_stage',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'amount' => 'decimal:2',
        'cost_of_sale' => 'decimal:2',
        'recurring_revenue' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
        'is_private' => 'boolean',
        'last_activity_at' => 'datetime',
        'days_in_stage' => 'integer',
    ];

    protected $appends = ['weighted_amount', 'is_overdue'];

    // Stage configuration
    public static array $stages = [
        'prospecting' => ['label' => 'Prospecting', 'probability' => 10, 'order' => 1],
        'qualification' => ['label' => 'Qualification', 'probability' => 25, 'order' => 2],
        'needs_analysis' => ['label' => 'Needs Analysis', 'probability' => 40, 'order' => 3],
        'value_proposition' => ['label' => 'Value Proposition', 'probability' => 60, 'order' => 4],
        'proposal' => ['label' => 'Proposal', 'probability' => 75, 'order' => 5],
        'negotiation' => ['label' => 'Negotiation', 'probability' => 90, 'order' => 6],
        'closed_won' => ['label' => 'Closed Won', 'probability' => 100, 'order' => 7],
        'closed_lost' => ['label' => 'Closed Lost', 'probability' => 0, 'order' => 8],
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($opportunity) {
            // Set default probability based on stage
            if (!$opportunity->probability && $opportunity->stage) {
                $opportunity->probability = self::$stages[$opportunity->stage]['probability'] ?? 50;
            }
        });

        static::updating(function ($opportunity) {
            // Track stage changes
            if ($opportunity->isDirty('stage')) {
                $opportunity->trackStageChange(
                    $opportunity->getOriginal('stage'),
                    $opportunity->stage
                );
            }
        });
    }

    // Relationships
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function competitorLostTo(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'competitor_lost_to');
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

    // Accessors
    public function getWeightedAmountAttribute(): float
    {
        return round($this->amount * ($this->probability / 100), 2);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->expected_close_date 
            && $this->expected_close_date->isPast() 
            && !in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    public function getStageLabelAttribute(): string
    {
        return self::$stages[$this->stage]['label'] ?? $this->stage;
    }

    public function getStageOrderAttribute(): int
    {
        return self::$stages[$this->stage]['order'] ?? 0;
    }

    public function getIsClosedAttribute(): bool
    {
        return in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    public function getIsWonAttribute(): bool
    {
        return $this->stage === 'closed_won';
    }

    public function getIsLostAttribute(): bool
    {
        return $this->stage === 'closed_lost';
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    public function scopeWon($query)
    {
        return $query->where('stage', 'closed_won');
    }

    public function scopeLost($query)
    {
        return $query->where('stage', 'closed_lost');
    }

    public function scopeByStage($query, string $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopeOverdue($query)
    {
        return $query->where('expected_close_date', '<', now())
            ->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    public function scopeClosingSoon($query, int $days = 30)
    {
        return $query->whereBetween('expected_close_date', [now(), now()->addDays($days)])
            ->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    public function scopeHighValue($query, float $amount = 10000)
    {
        return $query->where('amount', '>=', $amount);
    }

    // Methods
    public function moveToStage(string $newStage, ?string $reason = null): void
    {
        $oldStage = $this->stage;
        
        $this->update([
            'stage' => $newStage,
            'probability' => self::$stages[$newStage]['probability'] ?? $this->probability,
            'days_in_stage' => 0,
        ]);

        $this->recordActivity('opportunity_stage_change', [
            'description' => "Stage changed from {$oldStage} to {$newStage}" . ($reason ? ": {$reason}" : ''),
            'metadata' => [
                'old_stage' => $oldStage,
                'new_stage' => $newStage,
                'reason' => $reason,
            ],
        ]);
    }

    public function markAsWon(?string $reason = null): void
    {
        $this->update([
            'stage' => 'closed_won',
            'outcome' => 'won',
            'probability' => 100,
            'actual_close_date' => now(),
            'won_reason' => $reason,
            'forecast_category' => 'closed',
        ]);

        $this->recordActivity('opportunity_stage_change', [
            'description' => 'Opportunity won' . ($reason ? ": {$reason}" : ''),
            'metadata' => ['outcome' => 'won', 'reason' => $reason],
        ]);

        // Update contact engagement
        if ($this->contact) {
            $this->contact->increaseEngagementScore(20);
        }
    }

    public function markAsLost(string $reason, ?int $competitorId = null): void
    {
        $this->update([
            'stage' => 'closed_lost',
            'outcome' => 'lost',
            'probability' => 0,
            'actual_close_date' => now(),
            'loss_reason' => $reason,
            'competitor_lost_to' => $competitorId,
            'forecast_category' => 'omitted',
        ]);

        $this->recordActivity('opportunity_stage_change', [
            'description' => "Opportunity lost: {$reason}",
            'metadata' => [
                'outcome' => 'lost',
                'reason' => $reason,
                'competitor_id' => $competitorId,
            ],
        ]);
    }

    public function calculateDaysInStage(): void
    {
        $lastStageChange = $this->activities()
            ->where('type', 'opportunity_stage_change')
            ->latest()
            ->first();

        if ($lastStageChange) {
            $this->update([
                'days_in_stage' => $lastStageChange->created_at->diffInDays(now()),
            ]);
        }
    }

    private function trackStageChange(string $oldStage, string $newStage): void
    {
        // Reset days in stage
        $this->days_in_stage = 0;

        // Auto-update probability
        $this->probability = self::$stages[$newStage]['probability'] ?? $this->probability;

        // Auto-set close date for won/lost
        if (in_array($newStage, ['closed_won', 'closed_lost']) && !$this->actual_close_date) {
            $this->actual_close_date = now();
        }
    }

    public static function getStageOptions(): array
    {
        return collect(self::$stages)
            ->map(fn($config, $key) => [
                'value' => $key,
                'label' => $config['label'],
                'probability' => $config['probability'],
                'order' => $config['order'],
            ])
            ->sortBy('order')
            ->values()
            ->all();
    }
}