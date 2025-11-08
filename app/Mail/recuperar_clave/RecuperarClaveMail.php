<?php

namespace App\Mail\recuperar_clave;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecuperarClaveMail extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $usuIdRecuperarClave;
    public $usuarioRecuperarClave;
    public $usuCorreoRecuperarClave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuIdRecuperarClave, $usuarioRecuperarClave, $usuCorreoRecuperarClave)
    {
        $this->usuIdRecuperarClave = $usuIdRecuperarClave;
        $this->usuarioRecuperarClave = $usuarioRecuperarClave;
        $this->usuCorreoRecuperarClave = $usuCorreoRecuperarClave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recuperar_clave.recuperarClaveEmail')->subject('Info Recuperar Clave');
    }
}
