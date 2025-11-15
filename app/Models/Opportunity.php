<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory, SoftDeletes;
    public static $stages = [
        'new' => ['label' => 'New', 'color' => 'gray'],
        'qualification' => ['label' => 'Qualification', 'color' => 'blue'],
        'proposal' => ['label' => 'Proposal Sent', 'color' => 'purple'],
        'negotiation' => ['label' => 'Negotiation', 'color' => 'orange'],
        'closed_won' => ['label' => 'Closed Won', 'color' => 'green'],
        'closed_lost' => ['label' => 'Closed Lost', 'color' => 'red'],
    ];
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
        'amount' => 'decimal:2',
        'cost_of_sale' => 'decimal:2',
        'recurring_revenue' => 'decimal:2',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
        'is_private' => 'boolean',
        'last_activity_at' => 'datetime',
        'custom_fields' => 'array',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'related_to');
    }
    public function scopeOpen(Builder $query): Builder // <-- 2. BU FONKSİYONU EKLEYİN
    {
        return $query->whereNotIn('stage', [
            'closed_won',
            'closed_lost'
        ]);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
}