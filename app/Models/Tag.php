<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'slug',
        'color',
        'description',
        'category',
        'usage_count',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'taggable');
    }

    public function accounts()
    {
        return $this->morphedByMany(Account::class, 'taggable');
    }
}