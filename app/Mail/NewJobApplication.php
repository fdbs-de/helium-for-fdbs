<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $values;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $values)
    {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Neue Bewerbung als '.$this->name)->markdown('emails.NewJobApplication')->with([
            'name' => $this->name,
            'values' => $this->values,
            'date' => Carbon::now()->format('d.m.Y'),
            'time' => Carbon::now()->format('H:i'),
        ]);
    }
}
