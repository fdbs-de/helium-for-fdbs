<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'filename',
        'category',
        'group',
        'primary_tag',
        'tags',
        'has_cover',
        'cover_alt',
        'cover_size',
    ];

    protected $casts = [
        'has_cover' => 'boolean',
    ];

    protected $attributes = [
        'group' => '',
        'has_cover' => false,
        'cover_size' => 'cover',
    ];



    public static function boot()
    {
        parent::boot();



        self::updating(function ($model) {
            $extension = Str::lower(pathinfo($model->original['filename'], PATHINFO_EXTENSION));

            $old_filepath = 'documents/'.$model->original['filename'];
            $new_filepath = 'documents/'.$model->slug.'.'.$extension;

            // dd($model->filename);



            // If the slug changed, we need to rename the file, the cover, and update the filename.
            if ($model->slug !== $model->original['slug'])
            {
                // Rename file if it exists
                if (Storage::exists($old_filepath))
                {
                    Storage::move($old_filepath, $new_filepath);
                }

                // Rename cover if it exists
                if (Storage::exists($old_filepath.'.cover.png'))
                {
                    Storage::move($old_filepath.'.cover.png', $new_filepath.'.cover.png');
                }

                // Update filename
                $model->filename = $model->slug.'.'.$extension;
                // $model->save();
            }


            
            // If the cover was removed, we need to delete the cover.
            if ($model->original['has_cover'] && !$model->has_cover)
            {
                Storage::delete($new_filepath.'.cover.png');
                $model->cover_size = 'cover';
                $model->cover_alt = null;
                // $model->save();
            }
        });



        self::deleting(function ($model) {
            Storage::delete([
                'documents/' . $model->filename,                // original file
                'documents/' . $model->filename.'.cover.png',   // cover image
            ]);
        });
    }
}
