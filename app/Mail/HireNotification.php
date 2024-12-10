<?php
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class HireNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hireNotification;

    public function __construct($hireNotification)
    {
        $this->hireNotification = $hireNotification;
    }

    public function build()
    {
        return $this->subject($this->hireNotification['title'])
                    ->view('hire')
                    ->with('hireNotification', $this->hireNotification);
    }
}
