<?php

namespace App\Http\Responsable\proveedores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProveedorUpdate implements Responsable
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
        $idProveedor = request('id_proveedor', null);
        $idTipoPersona = request('id_tipo_persona', null);
        $idTipoDocumento = request('id_tipo_documento', null);
        $identificacion = request('identificacion', null);
        $nombreProveedor = request('nombres_proveedor', null);
        $apellidoProveedor = request('apellidos_proveedor', null);
        $telefonoProveedor = request('telefono_proveedor', null);
        $celularProveedor = request('celular_proveedor', null);
        $emailProveedor = request('email_proveedor', null);
        $idGenero = request('id_genero', null);
        $direccionProveedor = request('direccion_proveedor', null);
        $idEstado = request('id_estado', null);
        $nitProveedor = request('nit_proveedor', null);
        $proveedorJuridico = request('proveedor_juridico', null);
        $telefonoJuridico = request('telefono_juridico', null);
        
        if (isset($identificacion) && !is_null($identificacion) && !empty($identificacion)) {
            if(strlen($identificacion) < 6) {
                alert()->info('Info', 'El documento debe se de mínimo 6 caracteres');
                return back();
            }
        } else {
            if(strlen($nitProveedor) < 10) {
                alert()->info('Info', 'El Nit debe se de mínimo 10 caracteres incuyendo el guión y dígito de verificación');
                return back();
            }
        }

        try {
            $peticionProveedorUpdate = $this->clientApi->put($this->baseUri.'proveedor_update/'. $idProveedor , [
                'json' => [
                    'id_tipo_persona' => $idTipoPersona,
                    'id_tipo_documento' => $idTipoDocumento,
                    'identificacion' => $identificacion,
                    'nombres_proveedor' => $nombreProveedor,
                    'apellidos_proveedor' => $apellidoProveedor,
                    'telefono_proveedor' => $telefonoProveedor,
                    'celular_proveedor' => $celularProveedor,
                    'email_proveedor' => $emailProveedor,
                    'id_genero' => $idGenero,
                    'direccion_proveedor' => $direccionProveedor,
                    'id_estado' => $idEstado,
                    'nit_proveedor' => $nitProveedor,
                    'proveedor_juridico' => $proveedorJuridico,
                    'telefono_juridico' => $telefonoJuridico,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resProveedorUpdate = json_decode($peticionProveedorUpdate->getBody()->getContents());

            if($resProveedorUpdate) {
                return $this->respuestaExito('Proveedor editado satisfactoriamente.', 'proveedores.index');
            }
        } catch (Exception $e) {
            return $this->respuestaException('Exception, contacte a Soporte.');
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
