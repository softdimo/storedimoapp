<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use App\Models\Usuario;
use App\Traits\MetodosTrait;
class UsuarioStore implements Responsable
{
    use MetodosTrait;

    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    public function toResponse($request)
    {
        $nombreUsuario = request('nombre_usuario', null);
        $apellidoUsuario = request('apellido_usuario', null);
        $idTipoDocumento = request('id_tipo_documento', null);
        $identificacion = request('identificacion', null);
        $email = request('email', null);
        $idEstado = request('id_estado', null);
        $idRol = request('id_rol', null);
        $idTipoPersona = request('id_tipo_persona', null);
        $numeroTelefono = request('numero_telefono', null);
        $celular = request('celular', null);
        $idGenero = request('id_genero', null);
        $direccion = request('direccion', null);
        $fechaContrato = request('fecha_contrato', null);
        $fechaTerminacionContrato = request('fecha_terminacion_contrato', null);
        $idEmpresa = request('id_empresa') ? request('id_empresa') : session('id_empresa');

        if(strlen($identificacion) < 6)
        {
            alert()->info('Info', 'El documento debe se de mínimo 6 caracteres');
            return back();
        }
        
        // Consultamos si ya existe un usuario con la cedula ingresada
        $consultarIdentificacion = $this->consultarId($identificacion);
        
        if(isset($consultarIdentificacion) && !empty($consultarIdentificacion) && !is_null($consultarIdentificacion))
        {
            alert()->info('Info', 'Este número de documento ya existe.');
            return back();
        } else
        {
            // Contruimos el nombre de usuario
            $separarApellidos = explode(" ", $apellidoUsuario);
            $usuario = substr($this->quitarCaracteresEspeciales(trim($nombreUsuario)), 0,1) . trim($this->quitarCaracteresEspeciales($separarApellidos[0]));
            $usuario = preg_replace("/(Ñ|ñ)/", "n", $usuario);
            $usuario = strtolower($usuario);
            $complemento = "";

            while($this->consultaUsuario($usuario.$complemento))
            {
                $complemento++;
            }

            try
            {
                $peticionUsuarioStore = $this->clientApi->post($this->baseUri.'administracion/usuario_store', [
                    'json' => [
                        'nombre_usuario' => $nombreUsuario,
                        'apellido_usuario' => $apellidoUsuario,
                        'id_tipo_documento' => $idTipoDocumento,
                        'identificacion' => $identificacion,
                        'usuario' => $usuario.$complemento,
                        'email' => $email,
                        'id_rol' => $idRol,
                        'id_estado' => $idEstado,
                        'id_tipo_persona' => $idTipoPersona,
                        'numero_telefono' => $numeroTelefono,
                        'celular' => $celular,
                        'id_genero' => $idGenero,
                        'direccion' => $direccion,
                        'fecha_contrato' => $fechaContrato,
                        'fecha_terminacion_contrato' => $fechaTerminacionContrato,
                        'clave' => Hash::make($identificacion),
                        'clave_fallas' => 0,
                        'id_audit' => session('id_usuario'),
                        'id_empresa' => $idEmpresa
                    ]
                ]);

                $resUsuarioStore = json_decode($peticionUsuarioStore->getBody()->getContents());
                
                if(isset($resUsuarioStore) && !empty($resUsuarioStore) && $resUsuarioStore->success)
                {
                    return $this->respuestaExito(
                        "Usuario creado satisfactoriamente.<br>
                         El usuario es el correo: <strong>" .  $resUsuarioStore->usuario->email . "</strong><br>
                         Y la clave es: <strong>El número de documento</strong>",
                        'usuarios.index'
                    );
                }

            } catch (Exception $e)
            {
                return $this->respuestaException('Exception, contacte a Soporte.' . $e->getMessage());
            }
        }
    }

    private function consultarId($identificacion)
    {
        $queryIdentificacion = $this->clientApi->post($this->baseUri.'administracion/query_identificacion', [
            'json' => ['identificacion' => $identificacion]
        ]);
        return json_decode($queryIdentificacion->getBody()->getContents());
    }

    private function consultaUsuario($usuario)
    {
        try {
            $queryUsuario = $this->clientApi->post($this->baseUri.'administracion/query_usuario', [
                'json' => ['usuario' => $usuario]
            ]);
            return json_decode($queryUsuario->getBody()->getContents());

        } catch (Exception $e) {
            return $this->respuestaException('Exception, contacte a Soporte.' . $e->getMessage());
        }
    }

    private function respuestaExito($mensaje, $ruta)
    {
        alert()->success('Éxito', $mensaje)->toHtml();
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
