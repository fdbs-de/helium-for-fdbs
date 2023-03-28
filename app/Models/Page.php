<?php

namespace App\Models;

use App\Classes\Parsing\Regex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'props' => 'array',
        'is_component' => 'boolean',
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
        if ($this->renderer === 'php')
        {
            return $this->resolvePhp($slots, $props);
        }

        return $this->content;
    }

    public function resolvePhp($slots, $props)
    {
        $content = $this->content;

        // Replace all slots
        $content = preg_replace_callback(Regex::SLOT, function($matches) use ($slots) {
            $slot = $matches[1];

            if (isset($slots[$slot])) return $slots[$slot];

            if ($slot === 'slot') return $slots['default'];

            return '';
        }, $content);



        // Replace all props
        $content = preg_replace_callback(Regex::PROP, function($matches) use ($props) {
            $prop = $matches[1];

            if (isset($props[$prop])) return $props[$prop];

            return '';
        }, $content);



        // Replace all components
        $content = preg_replace_callback(Regex::COMPONENT, [$this, 'replaceComponentTags'], $content);

        return $content;
    }

    public function replaceComponentTags($matches)
    {
        $slug = $matches[1];
        $attributes = $this->parseAttributes($matches[2]);
        $innerContent = $matches[3];

        $component = Page::where('slug', $slug)->where('is_component', true)->first();

        if (!$component) return '';

        $componentSlots = [
            'default' => preg_replace_callback(Regex::COMPONENT, [$this, 'replaceComponentTags'], $innerContent),
        ];

        $componentProps = $attributes;

        return $component->resolvePhp($componentSlots, $componentProps);
    }

    public function parseAttributes($htmlAttributes)
    {
        $attributes = array();

        // Split the attribute string into an array of individual attribute strings
        $attributeStrings = preg_split('/\s+/', $htmlAttributes, -1, PREG_SPLIT_NO_EMPTY);

        // Loop through each attribute string and extract the name and value
        foreach ($attributeStrings as $attributeString) {
            if (preg_match('/^([^=]+)="([^"]+)"$/', $attributeString, $matches)) {
                $name = $matches[1];
                $value = $matches[2];
                $attributes[$name] = $value;
            }
        }

        return $attributes;
    }
}
