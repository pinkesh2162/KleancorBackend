<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{

    use Queueable, SerializesModels;

    public $welcomeMessage;

    public function __construct($welcomeMessage)
    {

        $this->welcomemessage = $welcomeMessage;
    }

    public function build()
    {

        return $this->subject('This is Testing Mail')
            ->view('emails.test');
    }
}
