<?php

namespace App\Http\Responsable\empresas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class EmpresaEdit implements Responsable
{
    protected $idEmpresa;

    public function __construct($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'administracion/empresa_edit/'. $this->idEmpresa);
            $empresa = json_decode($peticion->getBody()->getContents());

            return view('empresas.edit', compact('empresa'));

        } catch (Exception $e) {
            alert()->error('Editando la Empresa, contacte a Soporte.');
            return back();
        }
    }
}
