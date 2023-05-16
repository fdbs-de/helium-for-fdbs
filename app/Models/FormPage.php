<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'title',
        'order',
    ];

    protected $attributes = [
        'order' => 0,
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function inputs()
    {
        return $this->hasMany(FormInput::class);
    }



    public function duplicate(Form $form)
    {
        $item = $this->replicate()->fill([
            'form_id' => $form->id,
        ]);

        $item->push();

        foreach ($this->inputs as $input)
        {
            $input->duplicate($item);
        }

        return $item;
    }
}
