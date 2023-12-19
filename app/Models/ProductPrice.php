<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type', // E.g. SP, PP
        'currency_code',
        'price',
    ];



    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function countries()
    {
        return $this->morphToMany(Country::class, 'model', 'model_has_countries');
    }
}
