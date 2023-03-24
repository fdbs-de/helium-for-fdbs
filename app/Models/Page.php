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
        if ($this->type === 'php')
        {
            return $this->resolvePhp();
        }

        return $this->content;
    }

    public function resolvePhp()
    {
        $content = $this->content;

        $content = preg_replace_callback('/<component_(\w+)(.*?)>(.*?)<\/component_\w+>/s', function($matches) {
            $id = $matches[1];
            $props = $matches[2];
            $inner = $matches[3];

            $props = $this->parseAttributes($props);
            $component = PageComponent::where('id', $id)->first();

            if (!$component) return '';

            return $component->resolve(['default' => $inner], $props);
        }, $content);

        return $content;
    }

    public function parseAttributes($attributes)
    {
        $attributes = trim($attributes);
        $attributes = str_replace('=', '="', $attributes);
        $attributes = str_replace(' ', '" ', $attributes);
        $attributes = str_replace('" ', '"', $attributes);
        $attributes = str_replace('"', '" ', $attributes);
        $attributes = trim($attributes);

        $attributes = explode(' ', $attributes);

        if (count($attributes) === 1 && $attributes[0] === '') return [];

        $attributes = collect($attributes)->mapWithKeys(function($item) {
            $item = explode('=', $item);

            return [$item[0] => $item[1]];
        });

        return $attributes;
    }
}
