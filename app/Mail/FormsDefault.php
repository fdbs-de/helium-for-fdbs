<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormsDefault extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $addresses)
    {
        $this->content = $content;
        $this->subject = $subject;
        
        $this->to($addresses['to'] ?? null);
        $this->cc($addresses['cc'] ?? null);
        $this->bcc($addresses['bcc'] ?? null);
        $this->replyTo(...$addresses['replyTo']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.forms.FormsDefault')->with([
            'content' => $this->content,
        ]);
    }
}
