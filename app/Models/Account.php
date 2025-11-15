<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\HasActivities;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends Model implements Auditable
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
        'parent_account_id',
        'name',
        'legal_name',
        'tax_number',
        'tax_office',
        'website',
        'email',
        'phone',
        'fax',
        'billing_address_line1',
        'billing_address_line2',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'industry',
        'type',
        'size',
        'employee_count',
        'annual_revenue',
        'currency',
        'linkedin_url',
        'twitter_handle',
        'facebook_url',
        'instagram_handle',
        'source',
        'source_details',
        'description',
        'custom_fields',
        'last_activity_at',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'annual_revenue' => 'decimal:2',
        'employee_count' => 'integer',
        'last_activity_at' => 'datetime',
    ];

    protected $appends = ['full_address'];

    // Relationships
    public function parentAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'parent_account_id');
    }

    public function childAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'parent_account_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
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
    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([
            $this->billing_address_line1,
            $this->billing_address_line2,
            $this->billing_city,
            $this->billing_state,
            $this->billing_postal_code,
            $this->billing_country,
        ]);

        return implode(', ', $parts) ?: null;
    }

    public function getDomainAttribute(): ?string
    {
        if ($this->website) {
            $parsed = parse_url($this->website);
            return $parsed['host'] ?? null;
        }
        return null;
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->where('type', 'customer');
    }

    public function scopeProspects($query)
    {
        return $query->where('type', 'prospect');
    }

    public function scopeByIndustry($query, string $industry)
    {
        return $query->where('industry', $industry);
    }

    // Methods
    public function getPrimaryContact(): ?Contact
    {
        return $this->contacts()->orderBy('created_at')->first();
    }

    public function getTotalRevenue(): float
    {
        return $this->opportunities()
            ->where('stage', 'closed_won')
            ->sum('amount');
    }

    public function getOpenOpportunitiesValue(): float
    {
        return $this->opportunities()
            ->whereNotIn('stage', ['closed_won', 'closed_lost'])
            ->sum('amount');
    }
}