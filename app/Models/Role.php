<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'color',
        'icon',
        'guard_name',
    ];



    public function duplicate()
    {
        $item = $this->replicate()->fill([
            'name' => $this->findAvailableName(),
        ]);

        $item->push();

        $item->syncPermissions($this->permissions);

        return $item;
    }

    public function findAvailableName()
    {
        $name = $this->name;
        $count = 1;

        while (Role::where('name', $name)->exists())
        {
            $name = $this->name . '-' . $count;
            $count++;

            if ($count > 100) throw new \Exception('Too many duplicates');
        }

        return $name;
    }
}
