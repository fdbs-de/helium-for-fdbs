<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'rate',
    ];

    

    public function countries()
    {
        return $this->morphToMany(Country::class, 'model', 'model_has_countries');
    }
}
