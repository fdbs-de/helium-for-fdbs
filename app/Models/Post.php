<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Post extends Model
{
    use HasRoles, HasFactory;

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



    public static function getPublished($app)
    {
        return Post::where('scope', $app)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereDate('available_from', '<=', now())->orWhere('available_from', null);
            })
            ->where(function ($query) {
                $query->whereDate('available_to', '>=', now())->orWhere('available_to', null);
            })
            ->with(['category' => function ($query) {
                $query->select('id', 'name', 'slug', 'icon', 'color');
            }]);
    }

    public static function getPublishedByCategory($category, $app)
    {
        return Post::getPublished($app)
            ->where('category', $category);
    }

    public static function getPublishedBySlug($slug, $app)
    {
        return Post::getPublished($app)
            ->where('slug', $slug);
    }

    public static function getPublishedBySlugAndCategory($slug, $category, $app)
    {
        return Post::getPublished($app)
            ->where('slug', $slug)
            ->where('category', $category);
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
