<?php

namespace App\Http\Resources\Apps\Pages;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $settings = Setting::getGlobal(true, 'frontend');

        return [
            'title' => $this->title ?? null,
            'slug' => $this->slug ?? null,
            'content' => $this->content,
            'language' => $this->language ?? '*',
            'meta' => [
                'favicon' => $settings['design.favicon'] ?? null,
                'description' => $this->meta['description'] ?? null,
                'image' => $this->meta['image'] ?? null,
            ],
            'settings' => $settings,
            'prefetched_data' => $this->additional['prefetched_data'] ?? [],
        ];
    }
}
