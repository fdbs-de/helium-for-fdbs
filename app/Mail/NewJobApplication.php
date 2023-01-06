<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $jobName;
    public $formattedDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobName, $formattedDetails)
    {
        $this->jobName = $jobName;
        $this->formattedDetails = $formattedDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Eine neue Bewerbung für: '.$this->jobName)->markdown('emails.NewJobApplication')->with([
            'jobName' => $this->jobName,
            'formattedDetails' => $this->formattedDetails,
        ]);
    }
}
