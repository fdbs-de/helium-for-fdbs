<?php

namespace App\Models;

use App\Classes\Parsing\Regex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Page extends Model
{
    use HasRoles, HasFactory;

    protected $fillable = [
        'renderer',
        'title',
        'slug',
        'content',
        'status',
        'meta',
        'props',
        'language',
        'priority',
        'is_component',
        'parent_of',
        'strict_permissions',
        'require_auth',
        'require_verification',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'props' => 'array',
        'is_component' => 'boolean',
        'strict_permissions' => 'boolean',
        'require_auth' => 'boolean',
        'require_verification' => 'boolean',
    ];

    protected $attributes = [
        'language' => '*',
        'priority' => 0.5,
        'is_component' => false,
    ];



    // START: Actions
    public function duplicate() 
    {
        $item = $this->replicate()->fill([
            'title' => $this->title . ' (copy)',
            'slug' => $this->findAvailableSlug(),
            'status' => 'draft',
        ]);
        
        $item->push();

        return $item;
    }

    public function findAvailableSlug()
    {
        $slug = $this->slug;
        $count = 1;

        while (Page::where('slug', $slug)->exists())
        {
            $slug = $this->slug . '-' . $count;
            $count++;
        }

        return $slug;
    }
    // END: Actions



    // START: Resolve
    public function resolve($slots = [], $props = [])
    {
        return $this->content;
    }
    // END: Resolve
}
