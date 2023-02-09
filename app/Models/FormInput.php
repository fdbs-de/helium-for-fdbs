<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
