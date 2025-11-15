<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory, SoftDeletes;

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

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
}