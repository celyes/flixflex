<?php

namespace App\Models;

use App\Enums\MovieType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'type' => MovieType::class,
        'rating' => 'float'
    ];
}
