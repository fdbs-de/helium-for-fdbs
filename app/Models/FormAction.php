<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'type',
        'options',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected $attributes = [
        'order' => 0,
    ];



    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
