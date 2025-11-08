<?php

namespace App\Http\Responsable\unidades_medida;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UnidadMedidaUpdate implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idUmd;

    public function __construct($idUmd)
    {
        $this->idUmd = $idUmd;
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $descripcionUmd = ucwords(strtolower(request('descripcion_umd', null)));
        $abreviaturaUmd = ucwords(strtolower(request('abreviatura_umd', null)));

        // ===================================================================

        try {
            $peticion = $this->clientApi->put($this->baseUri.'unidad_medida_update/'.$this->idUmd, [
                'json' => [
                    'descripcion' => $descripcionUmd,
                    'abreviatura' => $abreviaturaUmd,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $respuesta = json_decode($peticion->getBody()->getContents());

            if (isset($respuesta->success) && $respuesta->success) {
                alert()->success('Proceso Exitoso', 'Unidad de medida editada satisfactoriamente');
                return redirect()->to(route('unidades_medida.index'));
            }

        } catch (Exception $e) {
            alert()->error('Error', 'Exception editando la nueva unidad de medida, contacte a Soporte.');
            return back();
        }
    }
}
