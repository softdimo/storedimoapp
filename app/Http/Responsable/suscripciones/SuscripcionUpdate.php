<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use App\Models\Suscripcion;
use App\Http\Responsable\suscripciones\RenovarSuscripcion;

class SuscripcionUpdate implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idSuscripcion;

    public function __construct($idSuscripcion)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idSuscripcion = $idSuscripcion;
    }

    // ===================================================================

    /* Helper privado para obtener las cabeceras estándar con JWT */
    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . session('api_jwt_token'),
            'Accept'        => 'application/json',
        ];
    }

    // ===================================================================

    public function toResponse($request)
    {
        $idPlanSuscrito = request('id_plan_suscrito', null);
        $diasTrial = request('dias_trial', null);
        $idTipoPago = request('id_tipo_pago', null);
        $valorSuscripcion = request('valor_suscripcion', null);
        $fechaInicial = request('fecha_inicial', null);
        $fechaFinal = request('fecha_final', null);
        $idEstadoSuscripcion = request('id_estado_suscripcion', null);
        $fechaCancelacion = request('fecha_cancelacion', null);
        $renovacionAutomatica = request('renovacion_automatica', null);
        $observacionesSuscripcion = request('observaciones_suscripcion', null);

        // ===================================================================

        // Obtener los datos actuales del producto antes de actualizar
        $peticionSuscripcionEmpresa = $this->clientApi->get('administracion/suscripcion_edit/'.$this->idSuscripcion, [
            'headers' => $this->getHeaders(),
        ]);
        $suscripcionActual = json_decode($peticionSuscripcionEmpresa->getBody()->getContents());

        try {
            $reqSuscripcionEmpresaUpdate = $this->clientApi->put('administracion/suscripcion_update/'.$this->idSuscripcion, [
                'headers' => $this->getHeaders(),
                'json' => [
                    'id_plan_suscrito' => $idPlanSuscrito ?? $suscripcionActual->id_plan_suscrito,
                    'dias_trial' => $diasTrial ?? $suscripcionActual->dias_trial,
                    'id_tipo_pago_suscripcion' => $idTipoPago ?? $suscripcionActual->id_tipo_pago_suscripcion,
                    'valor_suscripcion' => doubleval(str_replace(".", "", $valorSuscripcion)) ?? $suscripcionActual->valor_suscripcion,
                    'fecha_inicial' => $fechaInicial ?? $suscripcionActual->fecha_inicial,
                    'fecha_final' => $fechaFinal ?? $suscripcionActual->fecha_final,
                    'id_estado_suscripcion' => $idEstadoSuscripcion ?? $suscripcionActual->id_estado_suscripcion,
                    'fecha_cancelacion' => $fechaCancelacion ?? $suscripcionActual->fecha_cancelacion,
                    'renovacion_automatica' => $renovacionAutomatica ?? $suscripcionActual->renovacion_automatica,
                    'observaciones_suscripcion' => $observacionesSuscripcion ?? $suscripcionActual->observaciones_suscripcion,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resSuscripcionEmpresaUpdate = json_decode($reqSuscripcionEmpresaUpdate->getBody()->getContents());

            if(isset($resSuscripcionEmpresaUpdate->success) && $resSuscripcionEmpresaUpdate->success) {
                alert()->success('Proceso Exitoso', 'Suscripción editada satisfactoriamente');
                return redirect()->to(route('suscripciones.index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Actualizando la Suscripción, contacte a Soporte.');
            return back();
        }
    }

    public function guardarRenovacion($request)
    {
        try {
            // Extraer parámetros del request de forma compacta
            $parametros = $request->only([
                'empresa_actual',
                'id_empresa',
                'id_plan_suscrito',
                'valor_mensual',
                'valor_trimestral',
                'valor_semestral',
                'valor_anual',
                'descripcion_plan',
                'dias_trial',
                'id_tipo_pago',
                'valor_suscripcion',
                'fecha_inicial',
                'fecha_final'
            ]);

            $idEmpresa = $parametros['id_empresa'];
            $idPlanSuscrito = $parametros['id_plan_suscrito'];

            // Consultar suscripciones existentes
            $suscripciones = $this->consultarSuscripciones($idEmpresa, $idPlanSuscrito);

            // Si ya existe una suscripción, el trial no aplica
            if ($suscripciones->isNotEmpty()) {
                $parametros['dias_trial'] = 0;
            }

            // Validar si el usuario intenta adquirir nuevamente el plan Trial
            if ($this->usuarioYaTuvoTrial($suscripciones)) {
                alert()->info('Advertencia', 'Ya has adquirido el plan Trial, no lo puedes adquirir de nuevo');
                return back();
            }

            $renovarSuscripcion = new RenovarSuscripcion();
            return $renovarSuscripcion->guardarRenovacionSuscripcion($parametros);

        } catch (Exception $e) {
            alert()->error('Error', 'Renovando la suscripción, contácte a Soporte.');
            return back();
        }
    }

    private function consultarSuscripciones($idEmpresa, $idPlanSuscrito)
    {
        try {
            return Suscripcion::where('id_empresa_suscrita', $idEmpresa)
                ->where('id_plan_suscrito', $idPlanSuscrito)
                ->orderByDesc('id_suscripcion')
                ->get();

        } catch (Exception $e) {
            alert()->error('Error', 'Consultando suscripción, contácte a Soporte.');
            return back();
        }
    }

    private function usuarioYaTuvoTrial($suscripciones)
    {
        return $suscripciones->contains(function ($suscripcion)
        {
            return $suscripcion->id_plan_suscrito == 1;
        });
    }
}
