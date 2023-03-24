<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'content',
        'status',
        'props',
        'language',
    ];

    protected $casts = [
        'content' => 'array',
        'props' => 'array',
    ];

    protected $attributes = [
        'language' => '*',
    ];



    // START: Resolve
    public function resolve($slots, $props)
    {
        $content = $this->content;

        if ($this->type == 'php')
        {
            $content = $this->resolvePhp($slots, $props);
        }
    }



    // START: Resolve PHP
    public function resolvePhp($slots, $props)
    {
        $content = $this->content;

        return $content;
    }
}
