<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfaMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'recipient',
        'secret',
        'enabled_at',
    ];

    protected $casts = [
        'enabled_at' => 'datetime',
    ];

    protected $hidden = [
        'secret',
    ];



    public function authenticatable()
    {
        return $this->morphTo();
    }
}
