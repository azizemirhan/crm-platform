<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

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

    public function convertedContact()
    {
        return $this->belongsTo(Contact::class, 'converted_contact_id');
    }

    public function convertedAccount()
    {
        return $this->belongsTo(Account::class, 'converted_account_id');
    }

    public function convertedOpportunity()
    {
        return $this->belongsTo(Opportunity::class, 'converted_opportunity_id');
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