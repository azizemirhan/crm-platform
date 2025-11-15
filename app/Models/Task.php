<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\HasActivities;
use App\Traits\HasOwner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User; // <-- 1. BU SATIRI EKLEYİN

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToTeam;
    use HasOwner;
    use HasActivities;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'datetime',
    ];

      public function taskable()
    {
        return $this->morphTo();
    }

    // 2. 'scope' ÖNEKLERİNİ EKLEYİN (3 FONKSİYON)

    public function scopeAssignedTo(Builder $query, User $user): Builder
    {
        return $query->where('assigned_to_id', $user->id);
    }

    public function scopeDueToday(Builder $query): Builder
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<', today())
                     ->where('status', '!=', 'completed');
    }
    public function scopePending(Builder $query): Builder // <-- BU FONKSİYONU EKLEYİN
    {
        return $query->where('status', '!=', 'completed');
    }

    public function assignedUser() // <-- 1. BU YENİ İLİŞKİYİ EKLEYİN
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
    // app/Models/Task.php dosyanızda

}