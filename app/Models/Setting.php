<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];



    public static function getByKey($key)
    {
        return self::where('key', $key)->firstOrFail()->value;
    }

    public static function getGlobal($shouldTransform = false, $usecase = null)
    {
        $settings = self::get();
        
        if ($shouldTransform)
        {
            $settings = $settings->keyBy('key')->map->value;
        }



        if ($usecase === 'frontend')
        {
            $settings = $settings->only([
                'site.name',
                'site.slogan',
                'site.domain',
                'site.description',
                'site.language',
                'design.fonts',
                'design.colors',
                'design.favicon',
                'design.logos.color',
                'design.logos.light',
                'design.logos.dark',
                'design.icons.color',
                'design.icons.light',
                'design.icons.dark',
                'legal.disclaimer',
                'legal.privacy',
            ]);

            if (isset($settings['design.fonts']))
            {
                $settings['design.fonts'] = self::fontsArrayToCss($settings['design.fonts']);
            }

            if (isset($settings['design.colors']))
            {
                $settings['design.colors'] = self::colorsArrayToCss($settings['design.colors']);
            }
        }

        if ($usecase === 'props')
        {
            $settings = $settings->only([
                'site.name',
                'site.slogan',
                'site.domain',
                'site.description',
                'site.language',
                'design.fonts',
                'design.colors',
                'design.favicon',
                'design.logos.color',
                'design.logos.light',
                'design.logos.dark',
                'design.icons.color',
                'design.icons.light',
                'design.icons.dark',
                'legal.disclaimer',
                'legal.privacy',
            ]);

            if (isset($settings['design.fonts']))
            {
                $settings['design.fonts'] = self::fontsArrayToCss($settings['design.fonts']);
            }

            if (isset($settings['design.colors']))
            {
                $settings['design.colors'] = self::colorsArrayToCss($settings['design.colors']);
            }
        }
        
        return $settings;
    }



    public static function fontsArrayToCss($array)
    {
        $css = '';

        foreach ($array as $font)
        {
            $name = $font['name'];

            foreach ($font['files'] as $file)
            {
                $url = $file['url'];
                $style = $file['style'];
                $weight = $file['weight'];

                $css .= "@font-face { font-family: '$name'; src: url('$url'); font-style: $style; font-weight: $weight; }\n";
            }
        }

        return $css;
    }

    public static function colorsArrayToCss($array)
    {
        $css = '';

        foreach ($array as $color)
        {
            $name = $color['name'];
            $value = $color['value'];

            $css .= "--$name: $value; ";
        }

        return $css;
    }
}
