<?php

namespace App\Models;

use App\Classes\Drives\Drives;
use App\Permissions\Permissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class Media extends Model
{
    use HasRoles, HasFactory;

    protected $fillable = [
        'path',
        'belongs_to',
        'mediatype',
        'title',
        'alt',
        'caption',
        'description',
        'drive',
        'permission_mode',
    ];



    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $mime = Storage::mimeType($model->path);

            if (!$mime)
            {
                Storage::deleteDirectory($model->path);
            }
            else
            {
                Storage::delete($model->path);
            }
        });
    }



    // START: Relationships
    public function parent()
    {
        return $this->belongsTo(Media::class, 'belongs_to');
    }

    public function children()
    {
        return $this->hasMany(Media::class, 'belongs_to')->orderByRaw("FIELD(mediatype , 'folder') DESC")->orderBy('path', 'asc');
    }
    // END: Relationships



    public static function getDriveRoot($drive)
    {
        return Media::where('belongs_to', null)->where('mediatype', 'folder')->where('drive', $drive)->first() ?? null;
    }



    public function getRoot()
    {
        $model = $this;

        while ($model->parent)
        {
            $model = $model->parent;
        }

        return $model;
    }



    public function getDirectPermissionConfigAttribute()
    {
        return [
            'mode' => $this->permission_mode,
            'users' => [],
            'roles' => [],
            'profiles' => [],
        ];
    }

    public function getCalculatedPermissionConfigAttribute()
    {
        $model = $this;

        while ($model->parent && $model->permission_mode == 'inherit')
        {
            $model = $model->parent;
        }

        return $model->getDirectPermissionConfigAttribute();
    }



    public function getUrlAttribute()
    {
        $rootMedia = $this->getRoot();

        if ($rootMedia && $rootMedia->drive == 'private') return '/private/media/'.$this->id;

        return Storage::url($this->path);
    }



    public function move($old_path, $new_path)
    {
        function updatePathRecursive(Media $media, $old_path, $new_path)
        {
            // Replace only the start of the path
            $media->update(['path' => $new_path . substr($media->path, strlen($old_path))]);
    
            foreach ($media->children as $child)
            {
                updatePathRecursive($child, $old_path, $new_path);
            }
        }



        Storage::move($old_path, $new_path);

        updatePathRecursive($this, $old_path, $new_path);
    }



    public function canAccess(Request $request)
    {
        // Get root media
        $rootMedia = $this->getRoot();

        // Get drive
        $drive = $rootMedia ? Drives::getDrive($rootMedia->drive) : null;



        // If the media is in a drive that doesn't exist, it can't be accessed
        if (!$drive) return false;
        
        // If the media is in a public drive, everyone can access it
        if ($drive['private'] === false) return true;



        // Get permission config
        $permissionConfig = $this->calculatedPermissionConfig;

        // If the media is public, everyone can access it
        if ($permissionConfig['mode'] == 'public') return true;



        // Get user
        $user = $request->user();

        // If the request is unauthenticated, they can't access the media
        if (!$user) return false;
        
        // If the user has admin privileges, they can access all media
        if ($user->can([Permissions::SYSTEM_SUPER_ADMIN, Permissions::SYSTEM_ADMIN])) return true;



        // If the media has a custom permission config
        if ($permissionConfig['mode'] == 'custom')
        {
            // If the user is in the users list, they can access the media
            if (in_array($user->id, $permissionConfig['users'])) return true;
    
            // If the user has any of the roles in the roles list, they can access the media
            if ($user->hasAnyRole($permissionConfig['roles'])) return true;
    
            // If the user has any of the profiles in the profiles list, they can access the media
            if ($user->hasAnyProfile($permissionConfig['profiles'])) return true;
        }



        // Otherwise, they can't access the media
        return false;
    }
}
