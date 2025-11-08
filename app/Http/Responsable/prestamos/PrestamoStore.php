<?php

namespace App\Http\Responsable\prestamos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PrestamoStore implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    public function toResponse($request)
    {
        $idUsuario = request('id_usuario', null);
        $identificacion = request('identificacion', null);
        $idTipoPersona = request('id_tipo_persona', null);
        $fechaPrestamo = request('fecha_prestamo', null);
        $fechaLimite = request('fecha_limite', null);
        $valorPrestamo = request('valor_prestamo', null);
        $descripcion = request('descripcion', null);

        try {
            $peticionPrestamoStore = $this->clientApi->post($this->baseUri.'prestamo_store', [
                'json' => [
                    'id_usuario' => $idUsuario,
                    'identificacion' => $identificacion,
                    'id_tipo_persona' => $idTipoPersona,
                    'fecha_prestamo' => $fechaPrestamo,
                    'fecha_limite' => $fechaLimite,
                    'valor_prestamo' => $valorPrestamo,
                    'descripcion' => $descripcion,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resPrestamoStore = json_decode($peticionPrestamoStore->getBody()->getContents());

            if(isset($resPrestamoStore) && !is_null($resPrestamoStore) && !empty($resPrestamoStore)) {

                return $this->respuestaExito('Préstamo registrado satisfactoriamente.', 'prestamos.index');
                
            }
        } catch (Exception $e) {
            return $this->respuestaException('Exception, contacte a Soporte.' . $e->getMessage());
        }
    }

    // ===================================================================
    // ===================================================================

    // Método auxiliar para mensajes de exito
    private function respuestaExito($mensaje, $ruta)
    {
        alert()->success('Exito', $mensaje);
        return redirect()->to(route($ruta));
    }

    // ========================================================

    // Método auxiliar para manejar errores
    private function respuestaError($mensaje, $ruta)
    {
        alert()->error('Error', $mensaje);
        return redirect()->to(route($ruta));
    }

    // ========================================================

    // Método auxiliar para manejar excepciones
    private function respuestaException($mensaje)
    {
        alert()->error('Error', $mensaje);
        return back();
    }
}
