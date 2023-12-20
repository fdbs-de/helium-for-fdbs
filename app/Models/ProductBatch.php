<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_number',
        'disposition_id',
        'weight_total',
        'weight_per_item',
        'expiration_date',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_prices()
    {
        return $this->morphMany(ProductPrice::class, 'priceable');
    }
}
