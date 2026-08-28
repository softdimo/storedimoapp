<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class CambiarClaveUsuario implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $idUsuario = request('id_usuario', null);
        $nuevaClave = request('nueva_clave', null);
        $confirmarClave = request('confirmar_clave', null);

        // Validar token JWT en sesión antes de proceder
        $jwtToken = session('api_jwt_token');
        if (!$jwtToken) {
            alert()->error('Error', 'Sesión o token no válido. Por favor inicie sesión nuevamente.');
            return redirect()->to(route('login'));
        }

        // if(!isset($nuevaClave) || empty($nuevaClave) || is_null($nuevaClave) || !isset($confirmarClave) || empty($confirmarClave) || is_null($confirmarClave)) {
        //     alert()->error('Error','Usuario y Clave son requeridos!');
        //     return back();
        // }

        if (empty($nuevaClave) || empty($confirmarClave)) {
            alert()->error('Error', '¡Usuario y Clave son requeridos!');
            return back();
        }

        if ($nuevaClave !== $confirmarClave) {
            alert()->info('Info', '¡Las claves no coinciden!');
            return back();
        }

        try {
            if (!$this->validarContrasena($nuevaClave)) {
                alert()->info('Info', 'La contraseña no cumple con los requisitos de seguridad.');
                return back();
            }

            // 🟢 Petición con Header Bearer JWT e inyección limpia de URL
            $response = $this->clientApi->post("administracion/cambiar_clave_usuario/{$idUsuario}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'clave'    => $nuevaClave,
                    'id_audit' => session('id_usuario')
                ],
                // 'timeout' => 5.0
            ]);

            $claveCambiada = json_decode($response->getBody()->getContents());

            if ($claveCambiada) {
                // Comparar si el usuario que cambia la clave es el mismo logueado
                if ($idUsuario == session('id_usuario')) {
                    return view('mensajes.clave_cambiada_propia');
                } else {
                    alert()->success('Bien', 'Clave del usuario actualizada correctamente.');
                    return back();
                }
            } else {
                alert()->error('Error', 'Error al cambiar la clave, por favor contacte a Soporte.');
                return redirect()->to(route('cambiar_clave'));
            }

        } catch (Exception $e) {
            logger()->error("Exception CambiarClaveUsuario: " . $e->getMessage());
            alert()->error('Error', 'Error Exception, si el problema persiste, contacte a Soporte.');
            return back();
        }

        // if(isset($nuevaClave) || !empty($nuevaClave) || !is_null($nuevaClave) &&
        //     isset($confirmarClave) || !empty($confirmarClave) || !is_null($confirmarClave))
        // {
        //     if ($nuevaClave == $confirmarClave) {

        //         try {
        //             if (!$this->validarContrasena($nuevaClave)) {
        //                 alert()->info('Info', 'La contraseña no cumple con los requisitos de seguridad.');
        //                 return back();
        //             }

        //             $response = $this->clientApi->post($this->baseUri.'administracion/cambiar_clave/'.$idUsuario, [
        //                 'json' => [
        //                     'clave'     => $nuevaClave,
        //                     'id_audit'  => session('id_usuario')
        //             ]]);
        //             $claveCambiada = json_decode($response->getBody()->getContents());
    
        //             if($claveCambiada) {
        //                 // Comparar si el usuario que cambia la clave es el mismo logueado
        //                 if ($idUsuario == session('id_usuario')) {
        //                     return view('mensajes.clave_cambiada_propia');

        //                 } else {
        //                     // return view('mensajes.clave_cambiada_user');

        //                     alert()->success('Bien', 'Clave del usuario actualizada correctamente.');
        //                     return back();
        //                 }
    
        //             } else {
        //                 alert()->error('Error', 'Error al cambiar la clave, por favor contacte a Soporte.');
        //                 return redirect()->to(route('cambiar_clave'));
        //             }
        //         }
        //         catch (Exception $e) {
        //             alert()->error('Error', 'Error Exception, si el problema persiste, contacte a Soporte.');
        //             return back();
        //         }
        //     } else {
        //         alert()->info('Info','Las claves no coinciden!');
        //         return back();
        //     }
        // } else {
        //     alert()->error('Error','Nueva Clave es requerida!');
        //     return back();
        // }
    }

    private function validarContrasena($nuevaClave)
    {
        // Verifica que la contraseña tenga al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+\-\/_¿¡#.,:;=~^(){}\[\]<>`|"\'"])[A-Za-z\d@$!%*?&+\-\/_¿¡#.,:;=~^(){}\[\]<>`|"\'"]{6,}$/';
        return preg_match($regex, $nuevaClave);
    }
}
