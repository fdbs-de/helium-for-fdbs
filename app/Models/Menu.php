<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $fillable = [
        'status',
        'name',
        'content',
        'default_for',
    ];

    public $casts = [
        'content' => 'array',
    ];



    public function duplicate()
    {
        $item = $this->replicate()->fill([
            'name' => $this->name . ' (copy)',
            'status' => 'hidden',
        ]);

        $item->push();

        return $item;
    }
}
