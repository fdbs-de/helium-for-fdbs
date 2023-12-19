<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnits extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'weight',
        'length',
        'volume',
        'temperature',
        'speed',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
