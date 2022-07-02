<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportedUserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Änderungen an Ihrem Kunden-Account beim Fleischer Dienst Braunschweig')->markdown('emails.ImportedUserCreatedMail')->with([
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }
}
