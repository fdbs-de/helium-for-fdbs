<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected $attributes = [
        'status' => 'public',
    ];



    public function posts()
    {
        return $this->hasMany(Post::class, 'category');
    }

    
    
    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }
}
