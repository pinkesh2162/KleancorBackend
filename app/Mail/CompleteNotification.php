<?php
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class CompleteNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $completeNotification;

    public function __construct($completeNotification)
    {
        $this->completeNotification = $completeNotification;
    }

    public function build()
    {
        return $this->subject($this->completeNotification['title'])
                    ->view('complete-job')
                    ->with('completeNotification', $this->completeNotification);
    }
}
