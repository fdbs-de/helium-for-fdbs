<?php

namespace App\Rules\MediaLibrary;

use App\Classes\MediaLibrary\MediaPath as MediaPathClass;
use Illuminate\Contracts\Validation\InvokableRule;

class MediaPath implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!MediaPathClass::isValidPath($value))
        {
            $fail('The :attribute is an invalid path or does not exist in the storage.');
        }
    }
}
