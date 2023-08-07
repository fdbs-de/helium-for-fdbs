<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class PostCategory extends Model
{
    use HasRoles, HasFactory;

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

    public function users()
    {
        return $this->belongsToMany(User::class, 'post_category_user')->withPivot('role');
    }

    public function subcategories()
    {
        return $this->hasMany(PostCategory::class, 'subcategory_of');
    }

    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'subcategory_of');
    }
    

    
    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }



    // START: Queries
    public static function getPublished($apps, $roles = null, $search = [], $strict = false)
    {
        // if apps is string, convert to array
        if (is_string($apps)) $apps = [$apps];



        // if roles is "all", get all roles
        if ($roles === "all") $roles = Role::all()->pluck('id')->toArray();
        
        // if roles is string, convert to array
        if (is_string($roles)) $roles = [$roles];

        // if roles is null, set to empty array
        if (is_null($roles)) $roles = [];

        $query = PostCategory::select('*');

        $query
        ->whereIn('scope', $apps)
        ->where(function ($query) use ($roles) {
            $query
            // Categories the user has the roles to view
            ->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('id', $roles);
            })
            // Or Categories that don't require roles
            ->orWhereDoesntHave('roles');
        });

        if ($strict === true)
        {
            $query->where('status', 'published');
        }

        return $query;
    }
    // END: Queries



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
