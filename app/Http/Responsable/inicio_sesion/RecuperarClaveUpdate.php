<?php

namespace App\Http\Responsable\inicio_sesion;

use App\Models\Usuario;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class RecuperarClaveUpdate implements Responsable
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
        $usuIdRecuperarClave = request('id_usuario',null);
        $usuClaveNueva = request('clave_nueva',null);
        $usuclaveNuevaConfirmar = request('clave_nueva_confirmar',null);

        if(!isset($usuClaveNueva) || empty($usuClaveNueva) || is_null($usuClaveNueva) || !isset($usuclaveNuevaConfirmar) || empty($usuclaveNuevaConfirmar) || is_null($usuclaveNuevaConfirmar))
        {
            alert()->error('Error','Ambas clave son requeridos!');
            return back();
        }

        $message = "";

        if ($usuClaveNueva != $usuclaveNuevaConfirmar) {
            $message .= "El campo de nueva clave y Confirmación de clave deben ser iguales.";
        } else {
            try {
                if (!$this->validarContrasena($usuClaveNueva)) {
                    alert()->info('Info', 'La contraseña no cumple con los requisitos de seguridad.');
                    return back();
                }

                $peticion = $this->clientApi->post($this->baseUri.'administracion/cambiar_clave/'.$usuIdRecuperarClave, ['json' => [
                    'clave' => $usuClaveNueva,
                    'id_audit' => session('id_usuario')
                ]]);
                $claveUpdate = json_decode($peticion->getBody()->getContents());

                if($claveUpdate) {
                    alert()->success('Exito', 'Clave actualizada correctamente.');
                    return redirect()->to(route('login'));
                } else {
                   $message .= 'Error al actualizar la clave, si el problema persiste, contacte a soporte.';
                }
            } catch (Exception $e)
            {
                $message .= 'Error Exception, si el problema persiste, contacte a soporte.';
            }
        }

        alert()->error('error', $message);
        return back();
    }

    private function validarContrasena($usuClaveNueva)
    {
        // Verifica que la contraseña tenga al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+\-\/_¿¡#.,:;=~^(){}\[\]<>`|"\'"])[A-Za-z\d@$!%*?&+\-\/_¿¡#.,:;=~^(){}\[\]<>`|"\'"]{6,}$/';
        return preg_match($regex, $usuClaveNueva);
    }
}
