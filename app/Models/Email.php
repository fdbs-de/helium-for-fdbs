<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Email extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'email',
        'verified_at',
    ];



    public function emailable(): MorphTo
    {
        return $this->morphTo();
    }
}
