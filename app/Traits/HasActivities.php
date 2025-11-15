<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasActivities
{
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')
            ->orderBy('created_at', 'desc');
    }

    public function recordActivity(string $type, array $data = []): Activity
    {
        return $this->activities()->create([
            'type' => $type,
            'user_id' => auth()->id(),
            'description' => $data['description'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'completed_at' => now(),
        ]);
    }

    public function getLastActivityAttribute()
    {
        return $this->activities()->latest()->first();
    }

    public function updateLastActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }
}