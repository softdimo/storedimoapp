<?php

namespace App\Http\Responsable\proveedores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProveedorEdit implements Responsable
{
    protected $idProveedor;

    public function __construct($idProveedor)
    {
        $this->idProveedor = $idProveedor;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'proveedor_edit/'. $this->idProveedor, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $proveedorEdit = json_decode($peticion->getBody()->getContents());

            return view('proveedores.modal_editar_proveedor', compact('proveedorEdit'));

        } catch (Exception $e) {
            alert()->error('Error consultando el proveedor para editar, contacte a Soporte.');
            return back();
        }
    }
}
