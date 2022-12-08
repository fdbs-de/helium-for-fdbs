<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'mediatype',
        'title',
        'alt',
        'caption',
        'description',
    ];

    protected $appends = [
        'url',
    ];



    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
