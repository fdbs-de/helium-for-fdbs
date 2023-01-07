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
        'status' => 'published',
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



    public function duplicate()
    {
        $postCategory = $this->replicate()->fill([
            'name' => $this->name . ' (copy)',
            'slug' => $this->findAvailableSlug(),
            'status' => 'hidden',
        ]);
        
        $postCategory->push();

        return $postCategory;
    }

    public function findAvailableSlug()
    {
        $slug = $this->slug;
        $count = 1;

        while (PostCategory::where('slug', $slug)->exists()) {
            $slug = $this->slug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
