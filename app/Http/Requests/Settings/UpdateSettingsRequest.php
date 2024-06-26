<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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

    private const validators = [
        'general' => [
            'site_name' => 'present|nullable|string|max:255',
            'site_slogan' => 'present|nullable|string|max:255',
            'site_domain' => 'present|nullable|string|max:255',
            'site_description' => 'present|nullable|string|max:1000',
            'site_language' => 'required|string|in:en,de',
        ],
        'apps' => [
            'apps_blog_enabled' => 'required|boolean',
            'apps_jobs_enabled' => 'required|boolean',
            'apps_intranet_enabled' => 'required|boolean',
            'apps_wiki_enabled' => 'required|boolean',
        ],
        'design' => [
            'design_fonts' => 'present|array',
            'design_fonts.*.name' => 'required|string',
            'design_fonts.*.files' => 'required|array',
            'design_fonts.*.files.*.url' => 'required|string',
            'design_fonts.*.files.*.style' => 'required|in:normal,italic',
            'design_fonts.*.files.*.weight' => 'required|in:100,200,300,400,500,600,700,800,900',
            'design_colors' => 'present|array',
            'design_colors.*.name' => 'required|string',
            'design_colors.*.value' => 'required|string',
            'design_favicon' => 'present|nullable|string|max:255',
            'design_logos_color' => 'present|nullable|string',
            'design_logos_light' => 'present|nullable|string',
            'design_logos_dark' => 'present|nullable|string',
            'design_icons_color' => 'present|nullable|string',
            'design_icons_light' => 'present|nullable|string',
            'design_icons_dark' => 'present|nullable|string',
        ],
        'media' => [],
        'legal' => [
            'legal_disclaimer' => 'present|nullable|string|max:2047',
            'legal_privacy' => 'present|nullable|string|max:2047',
        ],
        'pages' => [
            'apps_pages_root_type' => 'present|nullable|in:static,redirect,route',
            'apps_pages_root_link' => 'present|nullable|string|max:1000',
        ],
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $page = $this->page;

        if (isset(self::validators[$page]))
        {
            return self::validators[$page];
        }
        
        return [];
    }
}
