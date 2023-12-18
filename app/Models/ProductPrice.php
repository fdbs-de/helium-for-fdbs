<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'currency_code',
        'amount',
    ];



    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function countries()
    {
        return $this->morphToMany(Country::class, 'model', 'model_has_countries');
    }
}
