<?php

namespace SQ10\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificacionTerminado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $arreglo; 

    public function __construct($arreglo)
    {
        $this->arreglo = $arreglo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notificacionTerminado')
                    ->subject('Proceso Terminado');
    }
}
