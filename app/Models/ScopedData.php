<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScopedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'scope',
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public function scope($query, $scope)
    {
        return $query->where('scope', $scope);
    }
}
