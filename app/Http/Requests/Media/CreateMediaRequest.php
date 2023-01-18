<?php

namespace App\Http\Requests\Media;

use App\Permissions\Permissions;
use App\Rules\MediaLibrary\MediaPath;
use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules()
    {
        return [
            'files' => ['array'],
            'files.*' => ['required', 'file', 'max:32768', 'mimes:jpg,jpeg,png,gif,svg,webp,mp4,mov,avi,mp3,wav,ogg,flac,zip,rar,7z,odt,doc,docx,xls,xlsx,ppt,pptx,pdf,txt,md,xml,psd,ai,eps,ttf,otf,woff,woff2,webm'],
            'path' => ['required', 'string', new MediaPath],
            'title' => ['nullable', 'string', 'max:255'],
            'alt' => ['nullable', 'string', 'max:1000'],
            'caption' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
