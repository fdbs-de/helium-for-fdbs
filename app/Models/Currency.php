<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimal_places',
    ];



    public function product_prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
