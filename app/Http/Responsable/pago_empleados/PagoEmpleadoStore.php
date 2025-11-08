<?php

namespace App\Http\Responsable\pago_empleados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PagoEmpleadoStore implements Responsable
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
        $valorBase = request('valor_base', null);
        $fechaInicioLabores = request('fecha_inicio_labores', null);
        $fechaFinalLabores = request('fecha_final_labores', null);
        $idTipoPago = request('id_tipo_pago', null);
        $idPeriodoPago = request('id_periodo_pago', null);
        $cantidadDias = request('cantidad_dias', null);
        $totalDiasPagar = request('total_dias_pagar', null);
        $idPorcentajeComision = request('id_porcentaje_comision', null);
        $valorDia = request('valor_dia', null);
        $fechaUltimoPago = request('fecha_ultimo_pago', null);
        $valorVentas = request('valor_ventas', null);
        $pendientePrestamos = request('pendiente_prestamos', null);
        $salarioNeto = request('salario_neto', null);
        $vacaciones = request('vacaciones', null);
        $comisiones = request('comisiones', null);
        $cesantias = request('cesantias', null);
        $total = request('total', null);

        try {
            $peticionPagoStore = $this->clientApi->post($this->baseUri.'pago_empleado_store', [
                'json' => [
                    'id_usuario' => $idUsuario,
                    'identificacion' => $identificacion,
                    'valor_base' => $valorBase,
                    'fecha_inicio_labores' => $fechaInicioLabores,
                    'fecha_final_labores' => $fechaFinalLabores,
                    'id_tipo_pago' => $idTipoPago,
                    'id_periodo_pago' => $idPeriodoPago,
                    'cantidad_dias' => $cantidadDias,
                    'total_dias_pagar' => $totalDiasPagar,
                    'id_porcentaje_comision' => $idPorcentajeComision,
                    'valor_dia' => $valorDia,
                    'fecha_ultimo_pago' => $fechaUltimoPago,
                    'valor_ventas' => $valorVentas,
                    'pendiente_prestamos' => $pendientePrestamos,
                    'salario_neto' => $salarioNeto,
                    'vacaciones' => $vacaciones,
                    'comisiones' => $comisiones,
                    'cesantias' => $cesantias,
                    'total' => $total,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resPagoStore = json_decode($peticionPagoStore->getBody()->getContents());

            if(isset($resPagoStore) && !is_null($resPagoStore) && !empty($resPagoStore)) {

                return $this->respuestaExito('Pago registrado satisfactoriamente.', 'pago_empleados.index');
                
            }
        } catch (Exception $e) {
            return $this->respuestaException('Exception Pago Empleados, contacte a Soporte.');
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
