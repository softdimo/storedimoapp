<?php

namespace App\Http\Responsable\unidades_medida;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UnidadMedidaEdit implements Responsable
{
    protected $idUmd;

    public function __construct($idUmd)
    {
        $this->idUmd = $idUmd;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'unidad_medida_edit/'. $this->idUmd, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $umdEdit = json_decode($peticion->getBody()->getContents());

            // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'editar_umd'); // valor por defecto

            return match ($tipoModal) {
                'estado_umd' => view('unidades_medida.modal_estado_umd', compact('umdEdit')),
                default  => view('unidades_medida.modal_editar_umd', compact('umdEdit')),
            };

        } catch (Exception $e) {
            alert()->error('Error consultando la unidad de medida para editar, contacte a Soporte.');
            return back();
        }
    }
}
