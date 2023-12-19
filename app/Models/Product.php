<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_group_id',
        'type',
        'name',
        'slug',
        'sku',
        'base_unit',
        'base_unit_amount',
        'status',
    ];



    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    public function product_prices()
    {
        return $this->morphMany(ProductPrice::class, 'priceable');
    }

    public function product_batches()
    {
        return $this->hasMany(ProductBatch::class, 'product_id');
    }

    public function product_dimensions()
    {
        return $this->hasMany(ProductDimensions::class, 'product_id');
    }

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function product_units()
    {
        return $this->hasMany(ProductUnits::class, 'product_id');
    }
}
