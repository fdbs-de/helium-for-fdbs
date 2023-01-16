<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
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
        'override_category_roles',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'tags' => 'array',
        'pinned' => 'boolean',
        'override_category_roles' => 'boolean',
        'available_from' => 'datetime',
        'available_to' => 'datetime',
    ];

    protected $attributes = [
        'pinned' => false,
        'status' => 'draft',
        'override_category_roles' => false,
    ];



    // START: Relationships
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category');
    }
    // END: Relationships



    // START: Queries
    public static function getPublished($apps, $roles = null)
    {
        // if apps is string, convert to array
        if (is_string($apps)) $apps = [$apps];



        // if roles is string, convert to array
        if (is_string($roles)) $roles = [$roles];

        // if roles is null, set to empty array
        if (is_null($roles)) $roles = [];

        // if roles is "all", get all roles
        if ($roles === "all") $roles = Role::all()->pluck('id')->toArray();

        return Post::
        with([
            'category' => function ($query) {
                $query->select('id', 'name', 'slug', 'icon', 'color');
            },
        ])
        ->whereIn('scope', $apps)
        ->where('status', 'published')

        ->where(function ($query) {
            $query
            ->whereDate('available_from', '<=', now())
            ->orWhere('available_from', null);
        })

        ->where(function ($query) {
            $query
            ->whereDate('available_to', '>=', now())
            ->orWhere('available_to', null);
        })

        // First check for "override_category_roles"
        ->where(function ($query) use ($roles) {

            // If true, query for posts that either dont have roles or match roles with the user
            $query
            ->where(function ($query) use ($roles) {
                $query
                ->where('override_category_roles', true)
                ->where(function ($query) use ($roles) {
                    $query
                    ->whereHas('roles', function ($query) use ($roles) {
                        $query->whereIn('id', $roles);
                    })
                    ->orWhereDoesntHave('roles');
                });
            })

            // If false/null, query for the posts which category either has no roles or match the user
            ->orWhere(function ($query) use ($roles) {
                $query
                ->where(function ($query) {
                    $query
                    ->where('override_category_roles', false)
                    ->orWhere('override_category_roles', null);
                })
                ->where(function ($query) use ($roles) {
                    $query
                    ->whereHas('category.roles', function ($query) use ($roles) {
                        $query->whereIn('id', $roles);
                    })
                    ->orWhereDoesntHave('category.roles');
                });
            });
        });
    }

    public static function getPublishedByCategory($category, $apps, $roles = null)
    {
        return Post::getPublished($apps, $roles)
            ->where('category', $category);
    }

    public static function getPublishedBySlug($slug, $apps, $roles = null)
    {
        return Post::getPublished($apps, $roles)
            ->where('slug', $slug);
    }

    public static function getPublishedBySlugAndCategory($slug, $category, $apps, $roles = null)
    {
        return Post::getPublished($apps, $roles)
            ->where('slug', $slug)
            ->where('category', $category);
    }
    // END: Queries



    // START: Actions
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
    // END: Actions
}
