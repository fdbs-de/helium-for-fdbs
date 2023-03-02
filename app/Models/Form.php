<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
    ];

    protected $attributes = [
        'type' => 'form',
        'status' => 'draft',
    ];

    

    public function pages()
    {
        return $this->hasMany(FormPage::class);
    }

    public function inputs()
    {
        return $this->hasManyThrough(FormInput::class, FormPage::class);
    }

    public function actions()
    {
        return $this->hasMany(FormAction::class);
    }



    public function submit($request)
    {
        $messages = [];

        $this->actions()->orderBy('order')->get()->each(function ($action) use (&$messages, $request) {
            $messages[] = $action->run($request);
        });

        return $messages;
    }



    public function getValidationsAttribute()
    {
        $validations = [];

        foreach ($this->inputs as $input)
        {
            $validations[$input->key] = $input->Rules;
        }

        return $validations;
    }
}
