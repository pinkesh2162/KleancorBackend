<?php
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class ApplyNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applyNotification;

    public function __construct($applyNotification)
    {
        $this->applyNotification = $applyNotification;
    }

    public function build()
    {
        return $this->subject($this->applyNotification['title'])
                    ->view('apply')
                    ->with('applyNotification', $this->applyNotification);
    }
}
