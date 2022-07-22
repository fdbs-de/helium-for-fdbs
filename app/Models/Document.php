<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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



    public static function boot()
    {
        parent::boot();

        self::updating(function ($model) {
            // ... code here
        });

        self::updated(function ($model) {
            // ... code here
        });

        self::deleting(function ($model) {
            Storage::delete([
                'documents/' . $model->filename,                 // original file
                'documents/' . $model->filename . '.cover.png',  // cover image
            ]);
        });
    }
}
