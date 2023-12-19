<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_product_id',
        'name',
    ];



    public function categories()
    {
        return $this->morphToMany(Category::class, 'model', 'model_has_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_group_id');
    }

    public function defaultProduct()
    {
        return $this->belongsTo(Product::class, 'default_product_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_group_tax');
    }
}
