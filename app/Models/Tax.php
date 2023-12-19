<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'priority',
        'name',
        'rate',
    ];

    

    public function countries()
    {
        return $this->morphToMany(Country::class, 'model', 'model_has_countries');
    }

    public function product_groups()
    {
        return $this->belongsToMany(ProductGroup::class, 'product_group_tax');
    }
}
