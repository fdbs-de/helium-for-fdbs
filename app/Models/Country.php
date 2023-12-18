<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];



    public function product_prices()
    {
        return $this->morphedByMany(ProductPrice::class, 'model', 'model_has_countries');
    }

    public function taxes()
    {
        return $this->morphedByMany(Tax::class, 'model', 'model_has_countries');
    }
}
