<?php

namespace App\Http\Responsable\auditorias;

use Illuminate\Contracts\Support\Responsable;

class AuditoriaIndex implements Responsable
{
    public function toResponse($request)
    {
        return view('auditorias.index');
    }
}
