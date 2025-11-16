<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Integration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'provider',
        'name',
        'type',
        'is_active',
        'credentials',
        'config',
        'last_used_at',
        'usage_count',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
        'last_used_at' => 'datetime',
        'usage_count' => 'integer',
    ];

    /**
     * Supported integration providers
     */
    const PROVIDERS = [
        'twilio' => ['name' => 'Twilio', 'type' => 'telephony'],
        'sendgrid' => ['name' => 'SendGrid', 'type' => 'email'],
        'mailgun' => ['name' => 'Mailgun', 'type' => 'email'],
        'smtp' => ['name' => 'SMTP', 'type' => 'email'],
        'stripe' => ['name' => 'Stripe', 'type' => 'payment'],
        'twilio_sendgrid' => ['name' => 'Twilio SendGrid', 'type' => 'email'],
    ];

    /**
     * Get the team that owns the integration
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Set encrypted credentials
     */
    public function setCredentialsAttribute($value)
    {
        $this->attributes['credentials'] = is_array($value)
            ? Crypt::encryptString(json_encode($value))
            : Crypt::encryptString($value);
    }

    /**
     * Get decrypted credentials
     */
    public function getCredentialsAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        try {
            $decrypted = Crypt::decryptString($value);
            return json_decode($decrypted, true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get credential by key
     */
    public function getCredential(string $key, $default = null)
    {
        $credentials = $this->credentials;
        return $credentials[$key] ?? $default;
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Scope: Active integrations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By provider
     */
    public function scopeProvider($query, string $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Scope: By type
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get provider display name
     */
    public function getProviderNameAttribute()
    {
        return self::PROVIDERS[$this->provider]['name'] ?? $this->provider;
    }

    /**
     * Check if provider is configured
     */
    public static function isConfigured(string $provider, ?int $teamId = null): bool
    {
        $teamId = $teamId ?? auth()->user()->team_id;

        return static::where('team_id', $teamId)
            ->where('provider', $provider)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Get integration config for a provider
     */
    public static function getConfig(string $provider, ?int $teamId = null): ?self
    {
        $teamId = $teamId ?? auth()->user()->team_id;

        return static::where('team_id', $teamId)
            ->where('provider', $provider)
            ->where('is_active', true)
            ->first();
    }
}
