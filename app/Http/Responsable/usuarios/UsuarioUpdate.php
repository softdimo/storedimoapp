<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UsuarioUpdate implements Responsable
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
        $idTipoPersona = request('id_tipo_persona', null);
        $nombreUsuario = request('nombre_usuario', null);
        $apellidoUsuario = request('apellido_usuario', null);
        $idTipoDocumento = request('id_tipo_documento', null);
        $identificacion = request('identificacion', null);
        $email = request('email', null);
        $idRol = request('id_rol', null);
        $numeroTelefono = request('numero_telefono', null);
        $celular = request('celular', null);
        $idGenero = request('id_genero', null);
        $direccion = request('direccion', null);
        $idEstado = request('id_estado', null);
        $fechaContrato = request('fecha_contrato', null);
        $fechaTerminacionContrato = request('fecha_terminacion_contrato', null);
        $idEmpresa = request('id_empresa') ? request('id_empresa') : session('id_empresa');


       /*  // Consultamos si ya existe un usuario con la cedula ingresada
        $consultarIdentificacion = $this->consultarId($identificacion);
        
        if(isset($consultarIdentificacion) && !empty($consultarIdentificacion) && !is_null($consultarIdentificacion)) {
            alert()->info('Info', 'Este número de documento ya existe.');
            return back();
        } else { */

            try
            {
                $peticionUsuarioUpdate = $this->clientApi->put($this->baseUri.'administracion/usuario_update/'. $idUsuario, [
                    'json' => [
                        'id_tipo_persona' => $idTipoPersona,
                        'nombre_usuario' => $nombreUsuario,
                        'apellido_usuario' => $apellidoUsuario,
                        'id_tipo_documento' => $idTipoDocumento,
                        'identificacion' => $identificacion,
                        'email' => $email,
                        'id_rol' => $idRol,
                        'numero_telefono' => $numeroTelefono,
                        'celular' => $celular,
                        'id_genero' => $idGenero,
                        'direccion' => $direccion,
                        'id_estado' => $idEstado,
                        'fecha_contrato' => $fechaContrato,
                        'fecha_terminacion_contrato' => $fechaTerminacionContrato,
                        'id_empresa' => $idEmpresa,
                        'id_audit' => session('id_usuario')
                    ],
                ]);
                $resUsuarioUpdate = json_decode($peticionUsuarioUpdate->getBody()->getContents());

                if ($resUsuarioUpdate->success) {
                    return $this->respuestaExito(
                        'Usuario editado satisfactoriamente.', 'usuarios.index'
                    );
                }
            } catch (Exception $e) {
                return $this->respuestaException('Exception, contacte a Soporte.');
            }
        // }
    }

    private function consultarId($identificacion)
    {
        $queryIdentificacion = $this->clientApi->post($this->baseUri.'administracion/query_identificacion', [
            'json' => ['identificacion' => $identificacion]
        ]);
        return json_decode($queryIdentificacion->getBody()->getContents());
    }

    // Método auxiliar para mensajes de exito
    private function respuestaExito($mensaje, $ruta)
    {
        alert()->success('Exito', $mensaje);
        return redirect()->to(route($ruta));
    }

    // Método auxiliar para manejar errores
    private function respuestaError($mensaje, $ruta)
    {
        alert()->error('Error', $mensaje);
        return redirect()->to(route($ruta));
    }

    // Método auxiliar para manejar excepciones
    private function respuestaException($mensaje)
    {
        alert()->error('Error', $mensaje);
        return back();
    }
}
