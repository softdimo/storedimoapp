<?php

namespace App\Http\Responsable\empresas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;

class EmpresaUpdate implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idEmpresa;

    public function __construct($idEmpresa)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idEmpresa = $idEmpresa;
    }

    // ===================================================================

    public function toResponse($request)
    {
        $nitEmpresa = request('nit_empresa', null);
        $nombreEmpresa = request('nombre_empresa', null);
        $telefonoEmpresa = request('telefono_empresa', null);
        $celularEmpresa = request('celular_empresa');
        $emailEmpresa = request('email_empresa');
        $direccionEmpresa = request('direccion_empresa');
        $idTipoBd = request('id_tipo_bd');
        $dbHost = Crypt::encrypt(request('db_host'));
        $dbDatabase = Crypt::encrypt(request('db_database'));
        $dbUsername = Crypt::encrypt(request('db_username'));
        $dbPassword = Crypt::encrypt(request('db_password'));
        $idEstado = request('id_estado');

        // ===================================================================

        $logoEmpresaBase64Edit = null;

        if ($request->hasFile('logo_empresa')) {
            $logoEmpresa = $request->file('logo_empresa');

            if ($logoEmpresa->isValid()) {
                // Validación de tipo MIME
                $tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
                $tipoMime = $logoEmpresa->getMimeType();

                if (!in_array($tipoMime, $tiposPermitidos)) {
                    alert()->error('Error', 'El tipo de imagen no es válido. Solo se permiten JPG, JPEG, PNG o WEBP.');
                    return back();
                }

                // Validación de tamaño (2 MB = 2048 KB)
                $tamanioMaximoKB = 2048;
                $tamanioArchivoKB = $logoEmpresa->getSize() / 1024;

                if ($tamanioArchivoKB > $tamanioMaximoKB) {
                    alert()->error('Error', 'La imagen excede el tamaño máximo permitido de 2 MB.');
                    return back();
                }

                // Codificación base64
                $contenido = file_get_contents($logoEmpresa);
                $logoEmpresaBase64Edit = 'data:' . $logoEmpresa->getMimeType() . ';base64,' . base64_encode($contenido);
            }
        }

        // ===================================================================

        // Obtener los datos actuales del producto antes de actualizar
        $peticionEmpresa = $this->clientApi->get($this->baseUri.'administracion/empresa_edit/'.$this->idEmpresa);
        $empresaActual = json_decode($peticionEmpresa->getBody()->getContents());

        try {
            $reqEmpresaUpdate = $this->clientApi->put($this->baseUri.'administracion/empresa_update/'.$this->idEmpresa, [
                'json' => [
                    'nit_empresa' => $nitEmpresa ?? $empresaActual->nit_empresa,
                    'nombre_empresa' => $nombreEmpresa ?? $empresaActual->nombre_empresa,
                    'telefono_empresa' => $telefonoEmpresa ?? $empresaActual->telefono_empresa,
                    'celular_empresa' => $celularEmpresa ?? $empresaActual->celular_empresa,
                    'email_empresa' => $emailEmpresa ?? $empresaActual->email_empresa,
                    'direccion_empresa' => $direccionEmpresa ?? $empresaActual->direccion_empresa,
                    'id_tipo_bd' => $idTipoBd ?? $empresaActual->id_tipo_bd,
                    'db_host' => $dbHost ?? $empresaActual->db_host,
                    'db_database' => $dbDatabase ?? $empresaActual->db_database,
                    'db_username' => $dbUsername ?? $empresaActual->db_username,
                    'db_password' => $dbPassword ?? $empresaActual->db_password,
                    'logo_empresa' => $logoEmpresaBase64Edit ?? $empresaActual->logo_empresa,
                    'id_estado' => $idEstado ?? $empresaActual->id_estado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resEmpresaUpdate = json_decode($reqEmpresaUpdate->getBody()->getContents());

            if(isset($resEmpresaUpdate->success) && $resEmpresaUpdate->success) {
                alert()->success('Proceso Exitoso', 'Empresa editada satisfactoriamente');
                return redirect()->to(route('empresas.index'));
            }
        } catch (Exception $e) {
            $this->handleError('Error Exception actualizando la empresa, contacte a Soporte.');
        }

        return back();
    }

    // Método auxiliar para manejar errores
    private function handleError($message)
    {
        alert()->error('Error', $message);
    }
}
