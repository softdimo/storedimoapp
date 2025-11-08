<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class BajaStore implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $responsableBaja = session('id_usuario');
        $fechaBaja = now()->format('Y-m-d H:i:s'); // Formato compatible con DATETIME en MySQL
        $idEstado = 1;

        $idProductos = request('id_producto', []); // Array de productos
        $cantidades = request('cantidad_baja', []); // Array de cantidades
        $idTiposBaja = request('id_tipo_baja', []); // Array tipos de baja
        $observaciones = request('observaciones_baja', []); // Array observaciones baja

        try {
            $reqBajaStore = $this->clientApi->post($this->baseUri.'baja_store', [
                'json' => [
                    'id_responsable_baja' => $responsableBaja,
                    'fecha_baja' => $fechaBaja,
                    'id_estado_baja' => $idEstado,
                    'productos' => array_map(function ($idProductos, $cantidades, $idTiposBaja, $observaciones) {
                        return [
                            'id_producto' => $idProductos,
                            'cantidad' => $cantidades,
                            'id_tipo_baja' => $idTiposBaja,
                            'observaciones' => $observaciones
                        ];
                    }, $idProductos, $cantidades, $idTiposBaja, $observaciones), // Construcción del array
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resBajaStore = json_decode($reqBajaStore->getBody()->getContents());

            if($resBajaStore) {
                alert()->success('Proceso Exitoso', 'Baja registrada satisfactoriamente');
                return redirect()->to(route('bajas_index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Registrando la baja, contacte a Soporte.');
            return back();
        }
    } // FIN function toResponse
} // FIN Class EntradaStore
