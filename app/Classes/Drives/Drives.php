<?php

namespace App\Classes\Drives;



class Drives
{
    public static function getDrive($drive)
    {
        return self::getDrives()[$drive] ?? null;
    }

    public static function getDrives()
    {
        return config('drives', []);
    }

    public static function getDriveAliases()
    {
        return array_map(function ($drive) {
            return $drive['alias'];
        }, self::getDrives());
    }
}