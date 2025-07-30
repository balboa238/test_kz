<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'poster'
    ];

    protected $with = [
        'genres'
    ];

    public function roles()
    {
        return $this->belongsToMany(Genre::class,'films_to_genres');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'films_to_genres');
    }
}
