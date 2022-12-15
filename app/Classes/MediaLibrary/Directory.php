<?php

namespace App\Classes\MediaLibrary;

use Illuminate\Support\Facades\Storage;

class Directory
{

    public $path;
    protected $items = [];

    // constructor
    public function __construct($path)
    {
        $this->path = $path;

        $items = array_merge(Storage::directories($path), Storage::files($path));

        $this->items = collect($items)->map(function ($file) {
            return new DirectoryItem($file);
        });
    }

    public function jsonSerialize()
    {
        return $this->items->map(function ($file) {
            return $file->jsonSerialize();
        });
    }
}