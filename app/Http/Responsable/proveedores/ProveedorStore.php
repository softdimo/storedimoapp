<?php

namespace App\Http\Responsable\proveedores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProveedorStore implements Responsable
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
        $idEstado = 1;
        $nitProveedor = request('nit_proveedor', null);
        $proveedorJuridico = request('proveedor_juridico', null);
        $telefonoJuridico = request('telefono_juridico', null);

        // ===================================================================
        // ===================================================================

        $validarCorreoProveedor = $this->validarCorreoProveedor($emailProveedor);

        if ($validarCorreoProveedor && isset($validarCorreoProveedor->email_proveedor) && $validarCorreoProveedor->email_proveedor == $emailProveedor) {
            alert()->info('Info', 'El correo ya existe');
            return back()->withInput();
        }

        if (isset($identificacion) && !is_null($identificacion) && !empty($identificacion)) {
            if(strlen($identificacion) < 6) {
                alert()->info('Info', 'El documento debe se de mínimo 6 caracteres');
                return back()->withInput();
            }

            $consultarIdentificacionProveedor = $this->consultarIdentificacionProveedor($identificacion);
        } else {
            if(strlen($nitProveedor) < 9) {
                alert()->info('Info', 'El Nit debe se de mínimo 9 caracteres incuyendo sin el dígito de verificación');
                return back()->withInput();
            }

            $consultarNitProveedor = $this->consultarNitProveedor($nitProveedor);
        }
        
        if( isset($consultarIdentificacionProveedor) && !empty($consultarIdentificacionProveedor) && !is_null($consultarIdentificacionProveedor) ||
            isset($consultarNitProveedor) && !empty($consultarNitProveedor) && !is_null($consultarNitProveedor) ) {

            alert()->info('Info', 'Este número identificación ya existe.');
            return back()->withInput();

        } else {
            try {
                $peticionProveedorStore = $this->clientApi->post($this->baseUri.'proveedor_store', [
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
                $resProveedorStore = json_decode($peticionProveedorStore->getBody()->getContents());

                if($resProveedorStore) {
                    return $this->respuestaExito('Proveedor creado satisfactoriamente.', 'proveedores.index');
                }
            } catch (Exception $e) {
                return $this->respuestaException('Exception, contacte a Soporte.' . $e->getMessage());
            }
        }
    }

    // ===================================================================
    // ===================================================================

    private function consultarIdentificacionProveedor($identificacion)
    {
        $queryIdentificacion = $this->clientApi->post($this->baseUri.'query_identificacion_proveedor', [
            'json' => [
                'identificacion' => $identificacion,
                'empresa_actual' => session('empresa_actual.id_empresa')
            ]
        ]);
        return json_decode($queryIdentificacion->getBody()->getContents());
    }

    // ===================================================================
    // ===================================================================
    
    private function consultarNitProveedor($nitProveedor)
    {
        $queryNitProveedor = $this->clientApi->post($this->baseUri.'query_nit_proveedor', [
            'json' => [
                'nit_proveedor' => $nitProveedor,
                'empresa_actual' => session('empresa_actual.id_empresa')
            ]
        ]);
        return json_decode($queryNitProveedor->getBody()->getContents());
    }

    // ======================================================================
    // ======================================================================

    public function validarCorreoProveedor($emailProveedor)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'validar_correo_proveedor', [
                'json' => [
                    'email_proveedor' => $emailProveedor
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            dd($e);
            alert()->error('Consultando el correo del proveedor, contacte a Soporte.');
            return back();
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
