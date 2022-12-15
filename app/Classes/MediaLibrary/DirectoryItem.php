<?php

namespace App\Classes\MediaLibrary;

use App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DirectoryItem
{
    
    public $path = '';
    public $mime = null;
    public $size = 0;
    public $url = '';
    public $media = null;

    // constructor
    public function __construct($path)
    {
        // Set base path
        $this->path = $path;

        $this->url = Storage::url($path);
        
        $this->mime = Storage::mimeType($this->path);
        $this->mime = $this->mime ? $this->mime : 'folder';



        if ($this->mime !== 'folder')
        {
            $this->size = Storage::size($this->path);
            $this->media = Media::select(['id', 'path', 'title', 'alt', 'caption', 'description'])->firstWhere('path', $this->path) ?? null;
        }
    }

    public function jsonSerialize()
    {
        return [
            'path' => $this->path,
            'mime' => $this->mime,
            'size' => $this->size,
            'url' => $this->url,
            'media' => $this->media,
        ];
    }
}