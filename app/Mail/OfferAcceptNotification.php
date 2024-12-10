<?php
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class OfferAcceptNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $offerNotification;

    public function __construct($offerNotification)
    {
        $this->offerNotification = $offerNotification;
    }

    public function build()
    {
        return $this->subject($this->offerNotification['title'])
                    ->view('offer-accept')
                    ->with('offerNotification', $this->offerNotification);
    }
}
