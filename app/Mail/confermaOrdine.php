<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class confermaOrdine extends Mailable
{
    use Queueable, SerializesModels;
    public $newOrder;
    public $arrvar2;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newOrder, $arrvar2)
    {
        $this->newOrder = $newOrder;
        $this->arrvar2 = $arrvar2;

    }


    public function build()
    {
        return $this->subject('Oggetto dell\'email')
            ->view('emails.confermaOrderCliente');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
