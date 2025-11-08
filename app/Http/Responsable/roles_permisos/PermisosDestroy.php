<?php

namespace App\Http\Responsable\roles_permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PermisosDestroy implements Responsable
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
            $arrayPermisos = request('permisos', null);
            $idUsuario = request('id_usuario', null);

            if(!isset($idUsuario) || is_null($idUsuario) || empty($idUsuario))
            {
                alert()->error("El campo usuario es obligatorio");
                return back();
            }

            if(isset($arrayPermisos) && !is_null($arrayPermisos) && !empty($arrayPermisos))
            {
                $peticionPermisoStore = $this->clientApi->post($this->baseUri . 'administracion/eliminar_permiso_usuario',
                [
                    'json' => [
                        'permissions' => $arrayPermisos,
                        'usuario_id' => $idUsuario,
                        'id_audit' => session('id_usuario')
                    ]
                ]);
    
                $permissions = json_decode($peticionPermisoStore->getBody()->getContents());

                if(isset($permissions->success) && $permissions->success)
                {
                    alert()->success($permissions->message);
                    return back();
                }

                if(isset($permissions->error) && $permissions->error)
                {
                    alert()->error($permissions->message);
                    return back();
                }

            } else
            {
                alert()->error("Debes seleccionar al menos un permiso");
                return back();
            }

        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error quitando los permisos!");
            return back();
        }
    }
}
