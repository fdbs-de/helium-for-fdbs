<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'filename',
        'category',
        'group',
        'has_cover',
        'cover_alt',
        'cover_size',
    ];

    protected $casts = [
        'has_cover' => 'boolean',
    ];

    protected $attributes = [
        'group' => '',
        'has_cover' => false,
        'cover_size' => 'cover',
    ];
}
