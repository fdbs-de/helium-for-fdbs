<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
{
    private function getMime($model)
    {
        $mime = explode("/", $model->mediatype);

        return [
            'string' => $model->mediatype,
            'type' => $mime[0] ?? null,
            'subtype' => $mime[1] ?? null,
        ];
    }



    private function isFolder($model)
    {
        return $model->mediatype == 'folder';
    }



    private function getSize()
    {
        return 0;
    }



    private function getPath($model)
    {
        $path = explode("/", $model->path);

        $filename = array_pop($path);
        $name_parts = explode(".", $filename);
        $extension = array_pop($name_parts);
        $name = implode(".", $name_parts);

        return [
            'path' => $model->path,
            'filename' => $filename,
            'extension' => $extension,
            'name' => $name,
            'url' => $model->url,
        ];
    }



    private function getVisual($model)
    {
        $visual = [
            'generic' => ['icon' => 'widgets', 'color' => '#57606f'],

            'folder.generic' => ['icon' => 'folder', 'color' => '#2f3542'],

            'image.vector' => ['icon' => 'polyline', 'color' => '#e84393'],
            'image.generic' => ['icon' => 'landscape', 'color' => '#3498db'],

            'video.generic' => ['icon' => 'videocam', 'color' => '#8e44ad'],
            'audio.generic' => ['icon' => 'music_note', 'color' => '#F79F1F'],

            'application.pdf' => ['icon' => 'category', 'color' => '#F40F02'],

            'text.plain' => ['icon' => 'notes', 'color' => '#747d8c'],
            'text.css' => ['icon' => 'css', 'color' => '#264de4'],
            'text.generic' => ['icon' => 'notes', 'color' => '#747d8c'],

            'document.text' => ['icon' => 'subject', 'color' => '#185abd'],
            'document.spreadsheet' => ['icon' => 'grid_on', 'color' => '#1D6F42'],
            'document.presentation' => ['icon' => 'slideshow', 'color' => '#c43f1d'],
        ];



        $mime = $this->getMime($model);

        if ($mime['type'] === 'folder') return $visual['folder.generic'];

        if ($mime['subtype'] === 'svg+xml') return $visual['image.vector'];
        if ($mime['type'] === 'image') return $visual['image.generic'];

        if ($mime['subtype'] === 'plain') return $visual['text.plain'];
        if ($mime['subtype'] === 'css') return $visual['text.css'];
        if ($mime['type'] === 'text') return $visual['text.generic'];

        if ($mime['subtype'] === 'pdf') return $visual['application.pdf'];
        if ($mime['subtype'] === 'vnd.openxmlformats-officedocument.wordprocessingml.document') return $visual['document.text'];
        if ($mime['subtype'] === 'vnd.oasis.opendocument.text') return $visual['document.text'];
        if ($mime['subtype'] === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') return $visual['document.spreadsheet'];
        if ($mime['subtype'] === 'vnd.openxmlformats-officedocument.presentationml.presentation') return $visual['document.presentation'];
        if ($mime['type'] === 'application') return $visual['generic'];

        if ($mime['type'] === 'video') return $visual['video.generic'];
        if ($mime['type'] === 'audio') return $visual['audio.generic'];

        return $visual['generic'];
    }



    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mediatype' => $this->mediatype,
            'is_folder' => $this->isFolder($this),
            'drive' => $this->drive,
            'permission_mode' => $this->permission_mode,
            'permission_config' => $this->directPermissionConfig,
            'calculated_permission_config' => $this->calculatedPermissionConfig,
            'meta' => [
                'title' => $this->title,
                'alt' => $this->alt,
                'caption' => $this->caption,
                'description' => $this->description,
            ],
            'size' => $this->getSize(),
            'path' => $this->getPath($this),
            'mime' => $this->getMime($this),
            'visual' => $this->getVisual($this),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
