<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta',
        'injected_data',
        'language',
        'priority',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'injected_data' => 'array',
    ];

    protected $attributes = [
        'language' => '*',
        'priority' => 0.5,
    ];
}
