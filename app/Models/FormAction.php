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



    public function run($request)
    {
        switch ($this->type)
        {
            case 'send-mail':
                return $this->runSendMail($request); break;
            case 'show-message':
                return $this->runShowMessage($request); break;
            default:
                return null; break;
        }
    }



    public function runSendMail($request)
    {
        $to = $this->replaceVariables($this->option('mail.to'), $request) ?? '';
        $cc = $this->replaceVariables($this->option('mail.cc'), $request) ?? '';
        $bcc = $this->replaceVariables($this->option('mail.bcc'), $request) ?? '';
        $from = $this->replaceVariables($this->option('mail.from'), $request) ?? '';
        $fromName = $this->replaceVariables($this->option('mail.fromName'), $request) ?? '';
        $subject = $this->replaceVariables($this->option('mail.subject'), $request) ?? '';
        $message = $this->replaceVariables($this->option('mail.message'), $request) ?? '';
        
        mail($to, $subject, $message, [
            'From' => $fromName . ' <' . $from . '>',
            'Cc' => $cc,
            'Bcc' => $bcc,
        ]);
    }



    public function runShowMessage($request)
    {
        return [
            'title' => $this->replaceVariables($this->option('message.title'), $request),
            'message' => $this->replaceVariables($this->option('message.message'), $request),
        ];
    }



    public function replaceVariables($string, $request, $fallbackReplacement = '')
    {
        if (!is_string($string)) return $string;

        return preg_replace_callback('/\{\{([^\}]+)\}\}/', function ($matches) use ($request, $fallbackReplacement) {
            $variable = $matches[1];

            if (substr($variable, 0, 6) == 'field.')
            {
                $variable = substr($variable, 6);
                return $request[$variable] ?? $fallbackReplacement;
            }

            return $fallbackReplacement;
        }, $string);
    }



    private function option($keyPath)
    {
        $keys = explode('.', $keyPath);
        $value = $this->options;

        foreach ($keys as $key)
        {
            if (!isset($value[$key])) return null;
            $value = $value[$key];
        }

        return $value;
    }
}
