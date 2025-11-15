<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

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
        'annual_revenue' => 'decimal:2',
        'last_activity_at' => 'datetime',
        'custom_fields' => 'array',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function parentAccount()
    {
        return $this->belongsTo(Account::class, 'parent_account_id');
    }

    public function childAccounts()
    {
        return $this->hasMany(Account::class, 'parent_account_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
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

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}