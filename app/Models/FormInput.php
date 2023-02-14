<?php

namespace App\Models;

use App\Rules\StepSize;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class FormInput extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'form_page_id',
        'type',
        'key',
        'options',
        'validation',
    ];

    protected $casts = [
        'options' => 'array',
        'validation' => 'array',
    ];



    public function page()
    {
        return $this->belongsTo(FormPage::class);
    }

    public function form()
    {
        return $this->page->form;
    }



    /**
     * Translate the validation rules to laravel validation rules
     *
     * @param  string  $value
     * @return array
     */
    public function getRulesAttribute()
    {
        // Base Variables
        $rules = [];
        $options = $this->options ?? [];
        $constraints = $this->validation ?? [];



        // Type Rules
        if (in_array($this->type, ['text']))
        {
            if (in_array($options['type'], ['text', 'textarea', 'password', 'tel', 'email', 'url'])) { array_push($rules, 'string'); }
            elseif (in_array($options['type'], ['number'])) { array_push($rules, 'numeric'); }

            if (in_array($options['type'], ['number']) && isset($constraints['step']) && $constraints['step'] > 0)
            {
                array_push($rules, new StepSize($constraints['step']));
            }
            
            if (in_array($options['type'], ['email'])) array_push($rules, 'email');

            if (in_array($options['type'], ['url'])) array_push($rules, 'url');
        }
        elseif (in_array($this->type, ['select', 'radio']))
        {
            array_push($rules, Rule::in(array_keys($this->selectableOptions)));
        }
        elseif (in_array($this->type, ['checkbox']))
        {
            array_push($rules, 'boolean');

            if (isset($constraints['required']) && $constraints['required'] === true)
            {
                array_push($rules, 'accepted');
            }
        }



        // Required Rule
        $rules[] = (isset($constraints['required']) && $constraints['required'] === true) ? 'required' : 'nullable';



        // Min length / Min value (for number inputs) Rule
        if (isset($constraints['min']) && is_numeric($constraints['min']) && in_array($this->type, ['text']))
        {
            $rules[] = 'min:' . $constraints['min'];
        }



        // Max length / Max value (for number inputs) Rule
        if (isset($constraints['max']) && is_numeric($constraints['max']) && in_array($this->type, ['text']))
        {
            $rules[] = 'max:' . $constraints['max'];
        }



        // Return the rules
        return $rules;
    }



    public function getSelectableOptionsAttribute()
    {
        $options = $this->options ?? [];
        $selectableOptions = [];

        foreach ($options['options'] ?? [] as $option)
        {
            $selectableOptions[$option['value'] ?? null] = $option['label'] ?? '';
        }

        return $selectableOptions;
    }
}
