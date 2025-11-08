<?php

namespace App\Http\Responsable\inicio_sesion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use App\Mail\recuperar_clave\RecuperarClaveMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\Usuario;

class RecuperarClave implements Responsable
{
    // ===================================================================
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        try
        {
            $email = request("email", null);
            $identificacion = request("identificacion", null);

            $peticion = $this->clientApi->post($this->baseUri.'administracion/consulta_recuperar_clave', ['json' => [
                'email' => $email,
                'identificacion' => $identificacion,
            ]]);
            $response = json_decode($peticion->getBody()->getContents());

            if (isset($response) && !is_null($response) && !empty($response))
            {
                $usuIdRecuperarClave = $response->id_usuario;
                $usuarioRecuperarClave = $response->usuario;
                $usuCorreoRecuperarClave = $response->email;

                Mail::to($usuCorreoRecuperarClave)
                    ->send(new RecuperarClaveMail($usuIdRecuperarClave, $usuarioRecuperarClave, $usuCorreoRecuperarClave));
                    alert()->info('Info','La información de recuperación de la clave, ha sido enviada al correo.');
                    return redirect()->to(route('login'));
            } else {
                alert()->error('Error','No encontramos este usuario.');
                return back();
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Exception, error enviando el email, contacte a soporte.');
            return back();
        }
    }
}
