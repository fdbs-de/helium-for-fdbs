<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'content',
        'status',
        'meta',
        'injected_data',
        'language',
        'priority',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'injected_data' => 'array',
    ];

    protected $attributes = [
        'language' => '*',
        'priority' => 0.5,
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
    public function resolve()
    {
        return $this->content;
    }
}
