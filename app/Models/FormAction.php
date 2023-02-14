<?php

namespace App\Models;

use App\Mail\FormsDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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
        $replyTo = $this->replaceVariables($this->option('mail.replyTo'), $request) ?? '';
        $replyToName = $this->replaceVariables($this->option('mail.replyToName'), $request) ?? '';
        $subject = $this->replaceVariables($this->option('mail.subject'), $request) ?? '';
        $message = $this->replaceVariables($this->option('mail.message'), $request) ?? '';

        if (!$to) return null;
        if (!$message) return null;
        if (!$subject) return null;

        Mail::send(new FormsDefault($subject, $message, [
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'replyTo' => [$replyTo, $replyToName],
        ]));

        return true;
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

        return preg_replace_callback('/\{\{([a-z0-9._-]+)\}\}/', function ($matches) use ($request, $fallbackReplacement) {
            return $this->getVariable($matches[1], $request) ?? $fallbackReplacement;
        }, $string);
    }



    /**
     * Try to get an option value by key path
     * Example: option('mail.to')
     * @param string $keyPath
     * @return mixed|null
     */
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



    /**
     * Get a variable value
     * HTML will be escaped
     * New lines will be replaced with <br>
     * @param string $variable
     * @param Request $request
     * @return string|null
     */
    private function getVariable($variable, $request)
    {
        // START: Input variables
        if (substr($variable, 0, 6) == 'field.')
        {
            $variable = substr($variable, 6);
            return $this->newLineToBr($this->escapeHtml($request[$variable])) ?? null;
        }
        // END: Input variables



        // START: System variables
        if ($variable == 'system.fields')
        {
            $fields = [];

            foreach ($request->all() as $key => $value)
            {
                $key = $this->newLineToBr($this->escapeHtml($key));
                $value = $this->newLineToBr($this->escapeHtml($value));

                $fields[] = "$key: <b>$value</b>";
            }

            return implode("<br>", $fields);
        };

        if ($variable == 'system.datetime') return date('d.m.Y H:i:s');
        if ($variable == 'system.date') return date('d.m.Y');
        if ($variable == 'system.time') return date('H:i:s');
        if ($variable == 'system.timestamp') return time();
        if ($variable == 'system.url') return $request->url() ?? 'Unknown';
        // END: System variables



        // START: Tracking variables
        if ($variable == 'tracking.ip') return $request->ip() ?? 'Unknown';
        if ($variable == 'tracking.user-agent') return $request->header('User-Agent') ?? 'Unknown';
        if ($variable == 'tracking.referer') return $request->header('Referer') ?? 'Unknown';
        if ($variable == 'tracking.country') return $request->header('CF-IPCountry') ?? 'Unknown';
        if ($variable == 'tracking.city') return $request->header('CF-IPCity') ?? 'Unknown';
        if ($variable == 'tracking.latitude') return $request->header('CF-IPLatitude') ?? 'Unknown';
        if ($variable == 'tracking.longitude') return $request->header('CF-IPLongitude') ?? 'Unknown';
        // END: Tracking variables


        return null;
    }



    /**
     * Escape HTML wrapper
     * @param string $string
     * @return string
     */
    private function escapeHtml($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * New line to <br> wrapper
     * @param string $string
     * @return string
     */
    private function newLineToBr($string)
    {
        return nl2br($string);
    }
}
