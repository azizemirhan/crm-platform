<?php

namespace App\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    protected static function bootBelongsToTeam(): void
    {
        // Otomatik team_id ekle
        static::creating(function ($model) {
            if (auth()->check() && !$model->team_id) {
                $model->team_id = auth()->user()->team_id;
            }
        });

        // Global scope - sadece kendi team'in verilerini göster
        static::addGlobalScope('team', function (Builder $builder) {
            if (auth()->check() && auth()->user()->team_id) {
                $builder->where('team_id', auth()->user()->team_id);
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}