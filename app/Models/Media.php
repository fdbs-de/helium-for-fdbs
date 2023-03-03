<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'status',
    ];



    // START: Relationships
    public function parent()
    {
        return $this->belongsTo(Media::class, 'belongs_to');
    }

    public function children()
    {
        return $this->hasMany(Media::class, 'belongs_to')->orderBy('mediatype', 'desc');
    }
    // END: Relationships



    public static function getRoot($status)
    {
        return Media::where('belongs_to', null)->where('mediatype', 'folder')->where('status', $status)->first() ?? null;
    }



    public function getUrlAttribute()
    {
        if ($this->status == 'private') return '/private/media/'+$this->id;

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
}
