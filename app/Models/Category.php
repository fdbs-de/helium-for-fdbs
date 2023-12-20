<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'type',
        'name',
        'slug',
        'icon',
        'color',
        'description',
        'status',
    ];



    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }



    public function product_groups()
    {
        return $this->morphedByMany(ProductGroup::class, 'model', 'model_has_category');
    }
}
