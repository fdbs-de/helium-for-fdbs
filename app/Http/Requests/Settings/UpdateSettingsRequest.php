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
            'design_fonts' => 'required|array',
            'design_fonts.*.name' => 'required|string',
            'design_fonts.*.files' => 'required|array',
            'design_fonts.*.files.*.url' => 'required|string',
            'design_fonts.*.files.*.style' => 'required|in:normal,italic',
            'design_fonts.*.files.*.weight' => 'required|in:100,200,300,400,500,600,700,800,900',
            'design_colors' => 'required|array',
            'design_colors.*.name' => 'required|string',
            'design_colors.*.value' => 'required|string',
            'design_favicon' => 'present|nullable|string|max:255',
            // 'design_logos' => 'required|array',
            // 'design_logos.color' => 'required|string',
            // 'design_logos.dark' => 'required|string',
            // 'design_logos.light' => 'required|string',
            // 'design_icons' => 'required|array',
            // 'design_icons.color' => 'required|string',
            // 'design_icons.dark' => 'required|string',
            // 'design_icons.light' => 'required|string',
        ],
        'media' => [],
        'legal' => [
            'legal_disclaimer' => 'present|nullable|string|max:2047',
            'legal_privacy' => 'present|nullable|string|max:2047',
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
