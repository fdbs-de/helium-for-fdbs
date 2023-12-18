<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWeight extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'type', // E.g. net, gross
        'weight',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
