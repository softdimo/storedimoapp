<?php

namespace App\Http\Responsable\roles_permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class RolesPermisos implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    /**
     * Helper privado para obtener los headers con JWT de forma centralizada
     */
    private function getHeaders()
    {
        $jwtToken = session('api_jwt_token');

        return [
            'Authorization' => 'Bearer ' . $jwtToken,
            'Accept'        => 'application/json',
        ];
    }

    public function toResponse($request)
    {
        try
        {
            $rol = request('role', null);

            $peticionRolStore = $this->clientApi->post($this->baseUri . 'administracion/guardar_rol', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'name'      => $rol,
                    'id_audit'  => session('id_usuario')
                ],
                'timeout' => 5.0
            ]);

            $rol = json_decode($peticionRolStore->getBody()->getContents());

            if(isset($rol->success) && $rol->success) {
                alert()->success($rol->message);
                return back();
            }

            if(isset($rol->error) && $rol->error) {
                alert()->error($rol->message);
                return back();
            }

        } catch (Exception $e) {
            alert()->error("Ha ocurrido un error creando el rol!");
            return back();
        }
    }

    public function crearPermiso($request)
    {
        try {
            $permiso = request('permission', null);

            $peticionPermissionStore = $this->clientApi->post($this->baseUri . 'administracion/guardar_permiso', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'permission' => $permiso,
                    'id_audit' => session('id_usuario')
                ],
                'timeout' => 5.0
            ]);

            $permiso = json_decode($peticionPermissionStore->getBody()->getContents());

            if (isset($permiso->success) && $permiso->success) {
                alert()->success($permiso->message);
                return back();
            }

            if (isset($permiso->error) && $permiso->error) {
                alert()->error($permiso->message);
                return back();
            }

        } catch (Exception $e) {
            alert()->error("Ha ocurrido un error creando el permiso!");
            return back();
        }
    }

    public function consultarPermisosPorUsuario($request)
    {
        try {
            $usuario = request('usuarioId', null);

            $peticionPermisos = $this->clientApi->post($this->baseUri . 'administracion/consultar_permisos', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'usuarioId' => $usuario,
                    'id_audit' => session('id_usuario')
                ],
                'timeout' => 5.0
            ]);

            return $peticionPermisos->getBody()->getContents();

            // return response($peticionPermisos->getBody()->getContents(), 200)
            //         ->header('Content-Type', 'application/json');

        } catch (Exception $e) {
            // return response()->json("error_exception");
            return response()->json(["error" => "error_exception", "message" => $e->getMessage()], 500);
        }
    }
}
