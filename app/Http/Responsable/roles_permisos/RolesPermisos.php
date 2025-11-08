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
    public function toResponse($request)
    {
        try
        {
            $rol = request('role', null);

            $peticionRolStore = $this->clientApi->post($this->baseUri . 'administracion/guardar_rol',
            [
                'json' => [
                    'name' => $rol,
                    'id_audit' => session('id_usuario')
                ]
            ]);

            $rol = json_decode($peticionRolStore->getBody()->getContents());

            if(isset($rol->success) && $rol->success)
            {
                alert()->success($rol->message);
                return back();
            }

            if(isset($rol->error) && $rol->error)
            {
                alert()->error($rol->message);
                return back();
            }

        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error creando el rol!");
            return back();
        }
    }

    public function crearPermiso($request)
    {
        try
        {
            $permiso = request('permission', null);

            $peticionPermissionStore = $this->clientApi->post($this->baseUri . 'administracion/guardar_permiso',
            [
                'json' => [
                    'permission' => $permiso,
                    'id_audit' => session('id_usuario')
                ]
            ]);

            $permiso = json_decode($peticionPermissionStore->getBody()->getContents());

            if(isset($permiso->success) && $permiso->success)
            {
                alert()->success($permiso->message);
                return back();
            }

            if(isset($permiso->error) && $permiso->error)
            {
                alert()->error($permiso->message);
                return back();
            }

        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error creando el permiso!");
            return back();
        }
    }

    public function consultarPermisosPorUsuario($request)
    {
        try
        {
            $usuario = request('usuarioId', null);

            $peticionPermisos = $this->clientApi->post($this->baseUri . 'administracion/consultar_permisos',
            [
                'json' => [
                    'usuarioId' => $usuario,
                    'id_audit' => session('id_usuario')
                ]
            ]);

            $permisos = $peticionPermisos->getBody()->getContents();

            return $permisos;

        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }
    }
}
