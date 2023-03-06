<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaProfile extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'profile',
        'media_id',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
