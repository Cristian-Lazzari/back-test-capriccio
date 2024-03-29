<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class confermaPrenotazioneAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $newOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newOrder)
    {
        $this->newOrder = $newOrder;
    }

    public function build()
    {
        return $this->subject('Oggetto dell\'email')
            ->view('emails.confermaResAdmin');
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
