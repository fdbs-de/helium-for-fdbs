<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $attributes = [
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
}
