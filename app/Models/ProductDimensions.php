<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDimensions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'type', // E.g. product, package
        'label', // For custom dimensions like parts of product
        'width',
        'height',
        'depth',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
