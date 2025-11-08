<?php

namespace App\Http\Responsable\inicio_sesion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseConnectionHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Traits\MetodosTrait;

class LoginStore implements Responsable
{
    use MetodosTrait;

    public function toResponse($request)
    {
        // Validación de campos requeridos
        $email = $request->input('email');
        $clave = $request->input('clave');

        if (empty($email) || empty($clave)) {
            alert()->error('Error', 'Correo y clave son requeridos');
            return back();
        }

        if(!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        }

        try {
            // 1. Buscar usuario en BD principal
            $user = $this->consultarEmail($email);

            if (empty($user) && $user != 'error_bd') {
                alert()->error('Error','NO se encontró ningún registro con el correo: ' . $email);
                return back();
            }

            if (!$user || $user === 'error_bd') {
                alert()->error('Error', 'Error consultando el usurio a la BD principal');
                return back();
            }

            // 2. Verificar estado del usuario
            if ($user['id_estado'] == 2) {
                alert()->error('Error', 'Usuario inactivo, contacte al administrador');
                return back();
            }

            // 3. Verificar intentos fallidos
            if ($user['clave_fallas'] >= 4) {
                $this->inactivarUsuario($user['id_usuario']);
                alert()->error('Error', 'Cuenta bloqueada por muchos intentos fallidos');
                return back();
            }

            // 4. Validar credenciales contra BD principal
            if (!Hash::check($clave, $user['clave']))
            {
                $this->actualizarClaveFallas($user['id_usuario'], $user['clave_fallas'] + 1);
                alert()->error('Error', 'Credenciales inválidas');
                return back();
            }

            // 5. Verificar empresa asociada
            if (!isset($user['empresa'])) {
                alert()->error('Error', 'Usuario no esta asociado a ninguna empresa');
                return back();
            }

            // 6. Configurar conexión tenant
            DatabaseConnectionHelper::configurarConexionTenant($user['empresa']);

            // 7. Crear sesión
            $this->crearVariablesSesion($user);
            $this->actualizarClaveFallas($user['id_usuario'], 0);

            return redirect()->route('home.index');

        } catch (Exception $e) {
            DatabaseConnectionHelper::restaurarConexionPrincipal();
            alert()->error('Error', 'Ocurrió un problema durante el login: ' . $e->getMessage());
            return back();
        }
    }

    private function crearVariablesSesion(array $user)
    {
        Session::flush();
        
        $permisos = $this->obtenerPermisos($user['id_usuario']);

        Session::put([
            'id_usuario' => $user['id_usuario'],
            'usuario' => $user['usuario'],
            'id_empresa' => $user['id_empresa'], // Nuevo
            'id_rol' => $user['id_rol'],
            'empresa_actual' => $user['empresa'],
            'permisos' => $permisos, // Nuevo
            'sesion_iniciada' => true,
            'tenant_connection' => true // Mantener si lo usas
        ]);
    }

    private function obtenerPermisos($idUsuario)
    {
        try {
            $client = new Client();
            $response = $client->post(env('BASE_URI').'consultar_permisos', [
                'json' => ['usuarioId' => $idUsuario],
                'timeout' => 3 // Timeout de 3 segundos
            ]);
            
            return json_decode($response->getBody(), true) ?? [];
            
        } catch (Exception $e) {
            // Logear error pero no bloquear login
            Log::error("Error obteniendo permisos: ".$e->getMessage());
            return [];
        }
    }

    private function consultarEmail($email)
    {
        try {
            // Realiza la solicitud POST a la API
            $client = new Client(['base_uri' => env('BASE_URI')]);

            $response = $client->post('administracion/validar_email_login', [
                    'json' => ['email' => $email]
                ]
            );
            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            alert()->error('Error consultando email');
            return redirect()->route('login');
        }
    }

    private function inactivarUsuario($idUsuario)
    {
        try {
            $client = new Client(['base_uri' => env('BASE_URI')]);
            $client->post('administracion/inactivar_usuario/'.$idUsuario, [
                'json' => ['id_audit' => $idUsuario]
            ]);
        } catch (Exception $e) {
            alert()->error('Error inactivar usuario');
            return redirect()->route('login');
        }
    }

    private function actualizarClaveFallas($idUsuario, $contador)
    {
        try {
            $client = new Client(['base_uri' => env('BASE_URI')]);
            $client->post('administracion/actualizar_clave_fallas/'.$idUsuario, [
                'json' => [
                    'clave_fallas' => $contador,
                    'id_audit' => $idUsuario
                ]
            ]);
        } catch (Exception $e)
        {
            alert()->error('Error actualizar clave fallas');
            return redirect()->route('login');
        }
    }
}
