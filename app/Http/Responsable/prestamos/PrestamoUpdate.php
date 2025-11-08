<?php

namespace App\Http\Responsable\prestamos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PrestamoUpdate implements Responsable
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
        $idPersona = request('id_persona', null);
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
        $idEstado = request('id_estado', null);
        $nitEmpresa = request('nit_empresa', null);
        $nombreEmpresa = request('nombre_empresa', null);
        $telefonoEmpresa = request('telefono_empresa', null);
        
        if (isset($identificacion) && !is_null($identificacion) && !empty($identificacion)) {
            if(strlen($identificacion) < 6) {
                alert()->info('Info', 'El documento debe se de mínimo 6 caracteres');
                return back();
            }
        } else {
            if(strlen($nitEmpresa) < 11) {
                alert()->info('Info', 'El Nit debe se de mínimo 11 caracteres incuyendo el guión y dígito de verificación');
                return back();
            }
        }

        try {
            $peticionPersonaUpdate = $this->clientApi->put($this->baseUri.'persona_update/'. $idPersona , [
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
            $resPersonaUpdate = json_decode($peticionPersonaUpdate->getBody()->getContents());

            if(isset($resPersonaUpdate) && !empty($resPersonaUpdate)) {

                if ($idTipoPersona == 3 || $idTipoPersona == 4) {
                    return $this->respuestaExito('Persona editada satisfactoriamente.', 'listar_proveedores');
                } else {
                    return $this->respuestaExito('Persona editada satisfactoriamente.', 'listar_clientes');
                }
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
