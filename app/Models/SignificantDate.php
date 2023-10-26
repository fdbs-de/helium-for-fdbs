<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SignificantDate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'date',
        'ignore_year',
        'repeats_annually',
    ];

    protected $casts = [
        'ignore_year' => 'boolean',
        'repeats_annually' => 'boolean',
    ];



    public function dateable(): MorphTo
    {
        return $this->morphTo();
    }
}
