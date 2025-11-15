<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'notable_type',
        'notable_id',
        'title',
        'content',
        'is_private',
        'is_pinned',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notable()
    {
        return $this->morphTo();
    }
}