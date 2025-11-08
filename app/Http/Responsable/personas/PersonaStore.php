<?php

namespace App\Http\Responsable\personas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PersonaStore implements Responsable
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
        $nombrePersona = request('nombres_persona', null);
        $apellidoPersona = request('apellidos_persona', null);
        $numeroTelefono = request('numero_telefono', null);
        $celular = request('celular', null);
        $email = request('email', null);
        $idGenero = request('id_genero', null);
        $direccion = request('direccion', null);
        $idEstado = 1;
        $nitEmpresa = request('nit_empresa', null);
        $nombreEmpresa = request('nombre_empresa', null);
        $telefonoEmpresa = request('telefono_empresa', null);

        if (isset($identificacion) && !is_null($identificacion) && !empty($identificacion)) {
            if(strlen($identificacion) < 6) {
                alert()->info('Info', 'El documento debe se de mínimo 6 caracteres');
                return back();
            }

            $consultarIdentificacion = $this->consultarIdPersona($identificacion);
        } else {
            if(strlen($nitEmpresa) < 11) {
                alert()->info('Info', 'El Nit debe se de mínimo 11 caracteres incuyendo el guión y dígito de verificación');
                return back();
            }

            $consultarNit = $this->consultarNitEmpresa($nitEmpresa);
        }

        if( $consultarIdentificacion ) {
            alert()->info('Info', 'Este número identificación ya existe.');
            return back();
        }

        if( isset($consultarNit) && !empty($consultarNit) && !is_null($consultarNit) ) {
            alert()->info('Info', 'Este número de Nit ya existe.');
            return back();
        }
        
        try {
            $peticionPersonaStore = $this->clientApi->post($this->baseUri.'persona_store', [
                'json' => [
                    'id_tipo_persona' => $idTipoPersona,
                    'id_tipo_documento' => $idTipoDocumento,
                    'identificacion' => $identificacion,
                    'nombres_persona' => $nombrePersona,
                    'apellidos_persona' => $apellidoPersona,
                    'numero_telefono' => $numeroTelefono,
                    'celular' => $celular,
                    'email' => $email,
                    'id_genero' => $idGenero,
                    'direccion' => $direccion,
                    'id_estado' => $idEstado,
                    'nit_empresa' => $nitEmpresa,
                    'nombre_empresa' => $nombreEmpresa,
                    'telefono_empresa' => $telefonoEmpresa,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resPersonaStore = json_decode($peticionPersonaStore->getBody()->getContents());

            if(isset($resPersonaStore->success) && $resPersonaStore->success) {
                return $this->respuestaExito('Cliente creado satisfactoriamente.', 'listar_clientes');
            }
        } catch (Exception $e) {
            return $this->respuestaException('Creando el cliente, contacte a Soporte.');
        }
    }

    // ===================================================================
    // ===================================================================

    private function consultarIdPersona($identificacion)
    {
        $queryIdentificacion = $this->clientApi->post($this->baseUri.'query_id_persona', [
            'json' => [
                'identificacion' => $identificacion,
                'empresa_actual' => session('empresa_actual.id_empresa')
            ]
        ]);
        return json_decode($queryIdentificacion->getBody()->getContents());
    }

    // ===================================================================
    // ===================================================================
    
    private function consultarNitEmpresa($nitEmpresa)
    {
        $queryNitEmpresa = $this->clientApi->post($this->baseUri.'query_nit_empresa', [
            'json' => [
                'nit_empresa' => $nitEmpresa,
                'empresa_actual' => session('empresa_actual.id_empresa')
            ]
        ]);
        return json_decode($queryNitEmpresa->getBody()->getContents());
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
