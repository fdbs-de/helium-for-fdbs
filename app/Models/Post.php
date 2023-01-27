<?php

namespace App\Models;

use App\Permissions\Permissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasRoles, HasFactory, Searchable;

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



    // START: Searchable
    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => implode(' ', $this->tags),
        ];
    }



    // START: Queries
    public static function getPublished($apps, User $user = null, $search = [], $strict = false)
    {
        // if apps is string, convert to array
        if (is_string($apps)) $apps = [$apps];



        // get roles
        $roles = $user ? $user->accessable_role_ids : [];

        // if roles is "all", get all roles
        if (key_exists('roles', $search) && $search['roles'] === "all") $roles = Role::all()->pluck('id')->toArray();



        $query = Post::with(['category' => function ($query) { $query->select('id', 'name', 'slug', 'icon', 'color'); }])
        ->whereIn('scope', $apps)
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



        // START: Strict Mode
        if (!$user || !$user->can(Permissions::APP_WIKI_ACCESS_ADMIN_PANEL) || !$user->can(Permissions::APP_WIKI_VIEW_CATEGORIES) || $strict === true)
        {
            $query
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
            });
        }
        // END: Strict Mode



        // START: Filter
        if (key_exists('category', $search)) $query->where('category', $search['category']);
        if (key_exists('slug', $search)) $query->where('slug', $search['slug']);
        // END: Filter



        // START: Search
        if (key_exists('query', $search))
        {
            // This setup is not ideal;
            // TODO: integrate it better with the query builder
            // $ids = Post::search($search['query'])->get()->pluck('id')->toArray();
            // $query->whereIn('id', $ids);

            $query->whereFuzzy(function ($query) use ($search) {
                $query
                ->orWhereFuzzy('title', $search['query'])
                ->orWhereFuzzy('content', $search['query'])
                ->orWhereFuzzy('tags', $search['query']);
            });
        }
        // END: Search



        return $query;
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
