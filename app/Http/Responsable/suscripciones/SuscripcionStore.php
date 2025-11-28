<?php

namespace App\Http\Responsable\empresas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;

class EmpresaStore implements Responsable
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

        // ========================================================

        $logoEmpresaBase64 = null;

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
                $logoEmpresaBase64 = 'data:' . $logoEmpresa->getMimeType() . ';base64,' . base64_encode($contenido);
            }
        }

        // ========================================================

        $consultarEmpresa = $this->consultarEmpresa($nitEmpresa, $nombreEmpresa);
        
        try {
            if (isset($consultarEmpresa) && !is_null($consultarEmpresa) && !empty($consultarEmpresa)) {
                alert()->warning('Cuidado', 'Empresa existente');
                return redirect()->route('empresas.create')->withInput();
            } else {
                $reqEmpresaStore = $this->clientApi->post($this->baseUri.'administracion/empresa_store', [
                    'json' => [
                        'nit_empresa' => $nitEmpresa,
                        'nombre_empresa' => $nombreEmpresa,
                        'telefono_empresa' => $telefonoEmpresa,
                        'celular_empresa' => $celularEmpresa,
                        'email_empresa' => $emailEmpresa,
                        'direccion_empresa' => $direccionEmpresa,
                        'id_tipo_bd' => $idTipoBd,
                        'db_host' => $dbHost,
                        'db_database' => $dbDatabase,
                        'db_username' => $dbUsername,
                        'db_password' => $dbPassword,
                        'logo_empresa' => $logoEmpresaBase64,
                        'id_estado' => $idEstado,
                        'id_audit' => session('id_usuario')
                    ]
                ]);
                $resEmpresaStore = json_decode($reqEmpresaStore->getBody()->getContents());
    
                if(isset($resEmpresaStore) && !empty($resEmpresaStore) && !is_null($resEmpresaStore)) {
                    alert()->success('Proceso Exitoso', 'Empresa creada satisfactoriamente');
                    return redirect()->to(route('empresas.index'));
                }
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Creando la empresa, contacte a Soporte.');
            return back();
        }
    }

    // ===================================================================
    // ===================================================================

    public function consultarEmpresa($nitEmpresa, $nombreEmpresa)
    {
        $consultarEmpresa = $this->clientApi->post($this->baseUri.'administracion/consultar_empresa', [
            'json' => [
                'nit_empresa' => $nitEmpresa,
                'nombre_empresa' => $nombreEmpresa
            ]
        ]);
        return json_decode($consultarEmpresa->getBody()->getContents());
    }
} // FIN Class EmpresaStore
