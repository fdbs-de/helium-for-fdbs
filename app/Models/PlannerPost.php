<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannerPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_group_id',
        'type',
        'content',
        'available_from',
        'available_to',
    ];

    public function group()
    {
        return $this->belongsTo(PlannerPostGroup::class, 'post_group_id');
    }
}
