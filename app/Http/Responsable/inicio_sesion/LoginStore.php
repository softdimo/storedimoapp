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
use Illuminate\Support\Str;

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
                alert()->error('Error', 'Error consultando el usuario a la BD principal');
                return back();
            }

            // =======================================================================================
            // VALIDACIÓN DE LA SUSCRIPCIÓN DE LA EMPRESA
            if ($user['id_empresa'] != 5) {

                $estadoSuscripcionEmpresa = $this->consultarEstadoSuscripcionEmpresa($user['id_empresa']);

                // Convertimos a array para una verificación más fácil si el objeto está vacío
                $estadoArray = (array) $estadoSuscripcionEmpresa;

                if (empty($estadoArray)) {
                    // La empresa NO tiene suscripción registrada.
                    alert()->error('Error de acceso', 'Su empresa no tiene ninguna suscripción registrada.');
                    return redirect()->route('login');
                }

                // 1. *** APLICAR VERIFICACIÓN POR FECHA ***
                $fechaFinalSuscripcion = $estadoSuscripcionEmpresa->fecha_final;
                $estadoActual = $estadoSuscripcionEmpresa->id_estado_suscripcion;

                // Verificar si la fecha final ya pasó Y si el estado aún es Activo (1) o Trial (10)
                // Usamos el Trait MetodosTrait para verificar si la fecha ha pasado (puedes crear el método)
                if ($this->fechaHaVencido($fechaFinalSuscripcion) && in_array($estadoActual, [1])) {
                    
                    // La fecha está vencida, pero el estado no se ha actualizado.
                    // Llama a la API para actualizar el estado antes de denegar el acceso.
                    $this->actualizarEstadoSuscripcion($estadoSuscripcionEmpresa->id_suscripcion, 2); // 2 = Inactivo
                    
                    alert()->error('Error de acceso', 'La fecha de su suscripción ha expirado. Por favor, renuevela para continuar.');
                    return redirect()->route('login');
                }

                // 2. *** VERIFICACIÓN POR ESTADO (Después de la verificación por fecha) ***
                // Ahora solo verificamos el estado que queda (si es 2, fue marcado por el CRON o la validación anterior)
                if ($estadoSuscripcionEmpresa->id_estado_suscripcion == 2) { // 2 = Inactivo, 1 = Activo
                    alert()->error('Error de acceso', 'Su suscripción registrada está inactiva; por favor renuevela para continuar.');
                    return redirect()->route('login');
                }
            }

            // =======================================================================================

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

    // private function crearVariablesSesion(array $user)
    // {
    //     Session::flush();
        
    //     $permisos = $this->obtenerPermisos($user['id_usuario']);

    //     Session::put([
    //         'id_usuario' => $user['id_usuario'],
    //         'usuario' => $user['usuario'],
    //         'id_empresa' => $user['id_empresa'], // Nuevo
    //         'id_rol' => $user['id_rol'],
    //         'empresa_actual' => $user['empresa'],
    //         'permisos' => $permisos, // Nuevo
    //         'sesion_iniciada' => true,
    //         'tenant_connection' => true // Mantener si lo usas
    //     ]);
    // }

    private function crearVariablesSesion(array $user)
    {
        // Limpiamos cualquier rastro de sesiones anteriores
        Session::flush();
        
        // 1. Generamos un token único e irrepetible para esta sesión específica
        $nuevoToken = Str::random(40);

        // 2. Notificamos a la API para que lo guarde en la BD principal
        // Si la API falla, es mejor capturarlo para no bloquear el login, 
        // pero idealmente debe ser exitoso.
        try {
            $this->actualizarTokenSesionBd($user['id_usuario'], $nuevoToken);
        } catch (Exception $e) {
            Log::error("No se pudo actualizar el session_token en la API: " . $e->getMessage());
            // Opcional: podrías decidir si dejas pasar el login o no
        }

        $permisos = $this->obtenerPermisos($user['id_usuario']);

        // 3. Guardamos todo en la sesión local del navegador
        Session::put([
            'id_usuario'        => $user['id_usuario'],
            'usuario'           => $user['usuario'],
            'id_empresa'        => $user['id_empresa'],
            'id_rol'            => $user['id_rol'],
            'empresa_actual'    => $user['empresa'],
            'permisos'          => $permisos,
            'sesion_iniciada'   => true,
            'tenant_connection' => true,
            'session_token'     => $nuevoToken // <--- El "sello" de seguridad
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

    private function consultarEstadoSuscripcionEmpresa($idEmpresa)
    {
        try {
            // Realiza la solicitud POST a la API
            $client = new Client(['base_uri' => env('BASE_URI')]);

            $response = $client->get('administracion/suscripcion_empresa_estado_login/'.$idEmpresa, [
                    'query' => []
                ]
            );
            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando la suscripción de la empresa');
            return redirect()->route('login');
        }
    }

    // Método para verificar si la fecha ya pasó
    private function fechaHaVencido($fecha)
    {
        if (empty($fecha)) {
            return true; // No hay fecha, no es válida
        }
        try {
            // La suscripción vence DESPUÉS del final del día de la fecha_final.
            // Si hoy es DÍA y fecha_final es DÍA, aún es válida.
            // Si hoy es DÍA+1, ya venció.
            return \Carbon\Carbon::parse($fecha)->endOfDay()->isPast();
        } catch (\Exception $e) {
            return true; // Si hay error de parseo, asumimos que no es válida
        }
    }

    private function actualizarEstadoSuscripcion($idSuscripcion, $nuevoEstado)
    {
        try {
            $client = new Client(['base_uri' => env('BASE_URI')]);
            // Asumiendo que crearás un nuevo endpoint en tu API para actualizar el estado
            $client->post('administracion/suscripcion_actualizar_estado_automatico/'.$idSuscripcion, [
                'json' => [
                    'id_estado_suscripcion' => $nuevoEstado,
                    'id_audit' => Session::get('id_usuario')
                ]
            ]);
            // No devolver nada, solo ejecutar la actualización
        } catch (Exception $e) {
            Log::error("Error actualizando estado de suscripción: ".$e->getMessage());
            // No alertamos para no interrumpir el login por un error menor
        }
    }

    private function actualizarTokenSesionBd($idUsuario, $token) {
        try {
            $client = new Client(['base_uri' => env('BASE_URI')]);
            $client->post('administracion/actualizar_token_sesion/'.$idUsuario, [
                'json' => [
                    'session_token' => $token,
                    'id_audit'      => $idUsuario
                ],
                'timeout' => 5
            ]);

            return true;

        } catch (Exception $e) {
            Log::error("Error al sincronizar el token con la API: ".$e->getMessage());
            throw new Exception("Error al sincronizar el token con la API.");
        }
    }
} // FIN class LoginStore implements Responsable
