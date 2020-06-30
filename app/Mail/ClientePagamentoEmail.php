<?php

namespace App\Mail;

use App\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClienteRegistroEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pagamento');
    }
}
