<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory, SoftDeletes;

    // Stage definitions
    public static $stages = [
        'qualification' => 'Değerlendirme',
        'proposal' => 'Teklif',
        'negotiation' => 'Müzakere',
        'closed_won' => 'Kazanıldı',
        'closed_lost' => 'Kaybedildi',
    ];

    // Source definitions
    public static $sources = [
        'web_form' => 'Web Formu',
        'google_ads' => 'Google Ads',
        'facebook_ads' => 'Facebook Ads',
        'linkedin' => 'LinkedIn',
        'referral' => 'Referans',
        'cold_call' => 'Soğuk Arama',
        'trade_show' => 'Fuar',
        'other' => 'Diğer',
    ];

    protected $fillable = [
        'team_id',
        'name',
        'description',
        'amount',
        'currency',
        'probability',
        'stage',
        'lead_source',
        'expected_close_date',
        'actual_close_date',
        'loss_reason',
        'contact_id',
        'account_id',
        'lead_id',
        'owner_id',
        'next_steps',
        'sales_cycle_days',
        'competitor',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
    ];

    // Relationships
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
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

    // Accessors
    public function getWeightedAmountAttribute()
    {
        return $this->amount * ($this->probability / 100);
    }

    public function getStageColorAttribute()
    {
        return match($this->stage) {
            'qualification' => 'info',
            'proposal' => 'primary',
            'negotiation' => 'warning',
            'closed_won' => 'success',
            'closed_lost' => 'danger',
            default => 'secondary'
        };
    }

    public function getIsWonAttribute()
    {
        return $this->stage === 'closed_won';
    }

    public function getIsLostAttribute()
    {
        return $this->stage === 'closed_lost';
    }

    public function getIsOpenAttribute()
    {
        return !in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    // Methods
    public function markAsWon()
    {
        $this->update([
            'stage' => 'closed_won',
            'actual_close_date' => now(),
            'probability' => 100
        ]);
    }

    public function markAsLost(string $reason = null)
    {
        $this->update([
            'stage' => 'closed_lost',
            'actual_close_date' => now(),
            'probability' => 0,
            'loss_reason' => $reason
        ]);
    }

    public function calculateSalesCycleDays()
    {
        if ($this->actual_close_date) {
            $this->sales_cycle_days = $this->created_at->diffInDays($this->actual_close_date);
            $this->save();
        }
    }
}
