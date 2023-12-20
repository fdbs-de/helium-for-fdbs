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



    protected static function booted()
    {
        static::deleting(function ($tax) {
            $tax->countries()->detach();
        });
    }

    

    public function countries()
    {
        return $this->morphToMany(Country::class, 'model', 'model_has_countries');
    }

    public function product_groups()
    {
        return $this->morphedByMany(ProductGroup::class, 'model', 'model_has_taxes');
    }
}
