<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'scope',
        'title',
        'slug',
        'category',
        'tags',
        'image',
        'content',
        'pinned',
        'status',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'available_from' => 'datetime',
        'available_to' => 'datetime',
        'tags' => 'array',
    ];

    protected $attributes = [
        'pinned' => false,
        'status' => 'draft',
    ];



    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category');
    }



    public function duplicate() 
    {
        $post = $this->replicate()->fill([
            'title' => $this->title . ' (copy)',
            'slug' => $this->findAvailableSlug(),
            'status' => 'draft',
        ]);
        
        $post->push();

        return $post;
    }

    public function findAvailableSlug()
    {
        $slug = $this->slug;
        $count = 1;

        while (Post::where('slug', $slug)->exists())
        {
            $slug = $this->slug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
