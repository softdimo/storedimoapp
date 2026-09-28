<?php

namespace App\Http\Responsable\inicio_sesion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Mail\recuperar_clave\RecuperarClaveMail;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RecuperarClave implements Responsable
{
    // ===================================================================
    // protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        // $this->baseUri = env('BASE_URI');
        // $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->clientApi = new Client(['base_uri' => env('BASE_URI')]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        try {
            $email = request("email", null);
            $identificacion = request("identificacion", null);

            // $peticion = $this->clientApi->post($this->baseUri.'administracion/consulta_recuperar_clave', ['json' => [
            $peticion = $this->clientApi->post('landing/consulta_recuperar_clave', [
                'headers' => [
                    'Accept'            => 'application/json',
                    'X-Landing-Api-Key' => env('LANDING_API_KEY'),
                ],
                'json' => [
                    'email'             => $email,
                    'identificacion'    => $identificacion,
                ],
                // 'timeout' => 5
            ]);
            $response = json_decode($peticion->getBody()->getContents());

            if (isset($response) && !is_null($response) && !empty($response)) {
                $usuIdRecuperarClave     = $response->id_usuario;
                $usuarioRecuperarClave   = $response->usuario;
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
            Log::error("Error en RecuperarClave: " . $e->getMessage());
            alert()->error('Error', 'Exception, error enviando el email, contacte a soporte.');
            return back();
        }
    }
}
