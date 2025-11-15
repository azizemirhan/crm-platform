<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'description',
        'logo',
        'plan',
        'max_users',
        'max_contacts',
        'trial_ends_at',
        'subscribed_at',
        'settings',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscribed_at' => 'datetime',
        'settings' => 'array',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}