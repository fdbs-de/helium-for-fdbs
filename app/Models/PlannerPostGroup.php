<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannerPostGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'owner_type',
        'owner_id',
        'title',
        'status',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function posts()
    {
        return $this->hasMany(PlannerPost::class, 'post_group_id');
    }



    public function getCurrentPostsAttribute()
    {
        return $this->posts()->whereDate('available_from', '<=', now())->whereDate('available_to', '>=', now())->get();
    }
}
