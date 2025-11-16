<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscribed_at' => 'datetime',
        'features' => 'array',
        'settings' => 'array',
        'deleted_at' => 'datetime',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'slug',
            'email',
            'schema_name',
            'owner_name',
            'owner_email',
            'plan',
            'status',
            'trial_ends_at',
            'subscribed_at',
            'max_users',
            'max_contacts',
            'max_storage_mb',
            'current_users',
            'current_contacts',
            'current_storage_mb',
            'features',
            'settings',
        ];
    }

    /**
     * Relationship: Tenant has many subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'tenant_id', 'id');
    }

    /**
     * Relationship: Tenant has one active subscription
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'tenant_id', 'id')
            ->where('status', 'active')
            ->latest();
    }

    /**
     * Check if tenant is on trial
     */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if trial has ended
     */
    public function trialHasEnded(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isPast();
    }

    /**
     * Check if tenant is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if tenant is suspended
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if user limit is reached
     */
    public function hasReachedUserLimit(): bool
    {
        return $this->current_users >= $this->max_users;
    }

    /**
     * Check if contact limit is reached
     */
    public function hasReachedContactLimit(): bool
    {
        return $this->current_contacts >= $this->max_contacts;
    }

    /**
     * Check if storage limit is reached
     */
    public function hasReachedStorageLimit(): bool
    {
        return $this->current_storage_mb >= $this->max_storage_mb;
    }

    /**
     * Get feature by key
     */
    public function hasFeature(string $feature): bool
    {
        return isset($this->features[$feature]) && $this->features[$feature] === true;
    }

    /**
     * Get setting by key
     */
    public function getSetting(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Update usage stats
     */
    public function updateUsage(array $usage): void
    {
        $this->update($usage);
    }

    /**
     * Suspend tenant
     */
    public function suspend(string $reason = null): void
    {
        $this->update([
            'status' => 'suspended',
            'settings' => array_merge($this->settings ?? [], [
                'suspension_reason' => $reason,
                'suspended_at' => now()->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Activate tenant
     */
    public function activate(): void
    {
        $this->update([
            'status' => 'active',
        ]);
    }

    /**
     * Get plan limits
     */
    public static function getPlanLimits(string $plan): array
    {
        return match($plan) {
            'trial' => [
                'max_users' => 3,
                'max_contacts' => 100,
                'max_storage_mb' => 500,
                'features' => [
                    'crm' => true,
                    'email' => false,
                    'reports' => false,
                    'api' => false,
                    'custom_fields' => false,
                ],
            ],
            'starter' => [
                'max_users' => 5,
                'max_contacts' => 1000,
                'max_storage_mb' => 2000,
                'features' => [
                    'crm' => true,
                    'email' => true,
                    'reports' => false,
                    'api' => false,
                    'custom_fields' => true,
                ],
            ],
            'professional' => [
                'max_users' => 25,
                'max_contacts' => 10000,
                'max_storage_mb' => 10000,
                'features' => [
                    'crm' => true,
                    'email' => true,
                    'reports' => true,
                    'api' => true,
                    'custom_fields' => true,
                ],
            ],
            'enterprise' => [
                'max_users' => 100,
                'max_contacts' => 50000,
                'max_storage_mb' => 50000,
                'features' => [
                    'crm' => true,
                    'email' => true,
                    'reports' => true,
                    'api' => true,
                    'custom_fields' => true,
                    'white_label' => true,
                    'priority_support' => true,
                ],
            ],
            default => [
                'max_users' => 5,
                'max_contacts' => 1000,
                'max_storage_mb' => 1000,
                'features' => [],
            ],
        };
    }
}
