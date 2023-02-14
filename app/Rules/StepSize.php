<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class StepSize implements InvokableRule
{
    public $stepSize;

    public function __construct($stepSize)
    {
        $this->stepSize = $stepSize;
    }



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
        // Value is a multiple of step
        if (abs(fmod($value, $this->stepSize)) > 0)
        {
            $fail('The ' . $attribute . ' must be a multiple of ' . $this->stepSize . '.');
        }
    }
}
