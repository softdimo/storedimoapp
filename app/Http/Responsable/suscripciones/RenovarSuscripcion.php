<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class RenovarSuscripcion implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            return view('suscripciones.renovar');

        } catch (Exception $e)
        {
            dd($e);
            alert()->error('Error cargando formulario de renovación, contácte a soporte');
            return back();
        }
    }
}
