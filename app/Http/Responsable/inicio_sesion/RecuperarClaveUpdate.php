<?php

namespace App\Http\Responsable\inicio_sesion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RecuperarClaveUpdate implements Responsable
{
    protected $clientApi;

    public function __construct()
    {
        $this->clientApi = new Client(['base_uri' => env('BASE_URI')]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $usuIdRecuperarClave    = request('id_usuario',null);
        $usuClaveNueva          = request('clave_nueva',null);
        $usuclaveNuevaConfirmar = request('clave_nueva_confirmar',null);

        $message = "";

        if (empty($usuClaveNueva) || empty($usuclaveNuevaConfirmar) || empty($usuIdRecuperarClave)) {
            $message .= "Todos los campos son requeridos";
        }

        if ($usuClaveNueva != $usuclaveNuevaConfirmar) {
            $message .= "La nueva clave y la confirmación deben ser iguales.";
        }

        // Si falló la presencia de campos o la coincidencia, no ejecutamos la regex ni la API
        if (!empty($message)) {
            alert()->error('Error', $message);
            return back();
        }

        if (!$this->validarContrasena($usuClaveNueva)) {
            alert()->info('Info', 'La contraseña no cumple con los requisitos de seguridad.');
            return back();
        }
        
        try {
            $peticion = $this->clientApi->post('landing/cambiar_clave/'.$usuIdRecuperarClave, [
                'headers' => [
                    'Accept'            => 'application/json',
                    'X-Landing-Api-Key' => env('LANDING_API_KEY'),
                ],
                'json' => [
                    'clave'    => $usuClaveNueva,
                    'id_audit' => $usuIdRecuperarClave
                ],
                // 'timeout' => 5
            ]);

            $claveUpdate = json_decode($peticion->getBody()->getContents());

            if ($claveUpdate) {
                alert()->success('Éxito', 'Clave actualizada correctamente.');
                return redirect()->to(route('login'));

            }
            // else {
            //     $message .= 'Error al actualizar la clave, si el problema persiste, contacte a soporte.';
            // }

        } catch (Exception $e) {
            // dd([
            //     'Linea'         => $e->getLine(),
            //     'Archivo'       => $e->getFile(),
            //     'Error Mensaje' => $e->getMessage(),
            // ]);
            Log::error("Error en RecuperarClaveUpdate: " . $e->getMessage());
            $message .= 'Error al actualizar la clave, si el problema persiste, contacte a soporte.';
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
