<?php

namespace App\Classes\MediaLibrary;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaPath
{
    private static $basePaths = [
        'public/media',
        'private/media',
    ];
    
    public static function isValidPath($path)
    {
        // Check if the path starts with one of the base paths
        foreach (self::$basePaths as $basePath)
        {
            if (Str::startsWith($path, $basePath)) return true;
        }

        return false;
    }
}