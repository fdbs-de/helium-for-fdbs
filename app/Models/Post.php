<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'scope',
        'title',
        'content',
        'pinned',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'available_from' => 'datetime',
        'available_to' => 'datetime',
    ];

    protected $attributes = [
        'scope' => 'public',
        'pinned' => false,
    ];
}
