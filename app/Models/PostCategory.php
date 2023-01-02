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
        'icon',
        'color',
        'description',
        'scope',
        'status',
        'subcategory_of',
    ];

    protected $attributes = [
        'status' => 'public',
    ];



    public function posts()
    {
        return $this->hasMany(Post::class, 'category');
    }

    public function subcategories()
    {
        return $this->hasMany(PostCategory::class, 'subcategory_of');
    }
    

    
    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getIconAttribute()
    {
        return $this->icon ?? 'category';
    }

    public function getColorAttribute()
    {
        return $this->color ?? 'gray';
    }
}
