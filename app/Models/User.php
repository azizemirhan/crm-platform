<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'team_id',
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'title',
        'department',
        'bio',
        'timezone',
        'locale',
        'preferences',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'two_factor_recovery_codes' => 'array',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function ownedTeam()
    {
        return $this->hasOne(Team::class, 'owner_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function ownedContacts()
    {
        return $this->hasMany(Contact::class, 'owner_id');
    }

    public function ownedAccounts()
    {
        return $this->hasMany(Account::class, 'owner_id');
    }

    public function ownedLeads()
    {
        return $this->hasMany(Lead::class, 'owner_id');
    }

    public function ownedOpportunities()
    {
        return $this->hasMany(Opportunity::class, 'owner_id');
    }
}