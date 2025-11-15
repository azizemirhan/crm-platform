<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{
    protected static function bootHasOwner(): void
    {
        static::creating(function ($model) {
            if (auth()->check() && !$model->owner_id) {
                $model->owner_id = auth()->id();
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeOwnedBy(Builder $query, User $user): Builder
    {
        return $query->where('owner_id', $user->id);
    }

    public function scopeVisible(Builder $query, User $user): Builder
    {
        // Admin tüm kayıtları görebilir
        if ($user->hasRole('admin') || $user->hasRole('sales_manager')) {
            return $query;
        }

        // Diğerleri sadece kendi kayıtlarını görebilir
        return $query->where('owner_id', $user->id);
    }
}