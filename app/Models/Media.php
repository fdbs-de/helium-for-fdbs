<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class Media extends Model
{
    use HasRoles, HasFactory;

    protected $fillable = [
        'path',
        'mediatype',
        'title',
        'alt',
        'caption',
        'description',
        'belongs_to',
    ];



    // START: Relationships
    public function belongs_to()
    {
        return $this->belongsTo(Media::class, 'belongs_to');
    }
    // END: Relationships



    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
