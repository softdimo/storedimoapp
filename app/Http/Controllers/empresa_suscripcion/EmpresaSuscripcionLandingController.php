<?php

namespace App\Http\Controllers\empresa_suscripcion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MetodosTrait;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Responsable\empresa_suscripcion\EmpresaSuscripcionStore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

class EmpresaSuscripcionLandingController extends Controller
{
    use MetodosTrait;
    protected $clientApi;

    public function __construct()
    {
        // $this->shareData();
        // Instanciamos el cliente directamente sin depender de la sesión (shareData)
        $this->clientApi = new Client([
            'base_uri' => config('services.lumen.base_uri', env('BASE_URI')),
            // Sin timeout corto: en Hostinger las llamadas landing pueden demorar
        ]);
    }

    // ======================================================================
    // ======================================================================

    private function getLandingHeaders(): array
    {
        return [
            'Accept'            => 'application/json',
            // Debe coincidir exactamente con LandingApiKeyMiddleware en la API
            'X-Landing-Api-Key' => config('services.lumen.landing_key', env('LANDING_API_KEY')),
        ];
    }

    // ======================================================================
    // ======================================================================

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    // ======================================================================
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return new EmpresaSuscripcionStore();
                
        } catch (Exception $e) {
            alert()->error("Exception Store Empresas Landing!");
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idEmpresa)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    public function nitValidatorLanding(Request $request)
    {
        try {
            $request->validate([
                'nit_empresa' => 'required|numeric|digits:10' // Mucho más seguro y limpio
            ], [
                'nit_empresa.required' => 'El NIT es obligatorio.',
                'nit_empresa.digits'   => 'El NIT debe tener exactamente 10 dígitos.',

            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valido'=> false,
                'error' => $e->validator->errors()->first('nit_empresa')
            ], 422);
        }
    
        try {
            $response = $this->clientApi->post('landing/validar_nit_landing', [
                'headers' => $this->getLandingHeaders(),
                'json'    => ['nit_empresa' => $request->input('nit_empresa')]
            ]);
        
            return response()->json(json_decode($response->getBody()->getContents(), true));
        
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo validar el NIT en el servicio externo.',
                'valido' => false
            ], 500);
        }
    }

    // ======================================================================
    // ======================================================================

    public function documentoValidatorLanding(Request $request)
    {
        try {
            $response = $this->clientApi->post('landing/validar_documento_landing', [
                'headers' => $this->getLandingHeaders(),
                'json'    => ['ident_empresa_natural' => $request->input('ident_empresa_natural')]
            ]);
        
            return response()->json(json_decode($response->getBody()->getContents(), true));
        
        } catch (Exception $e) {
            return response()->json([
                'error'  => 'No se pudo validar el número del documento en la BD.',
                'valido' => false
            ], 500);
        }
    }

    // ======================================================================
    // ======================================================================

    public function validarCorreoEmpresaLanding(Request $request)
    {
        try {
            $response = $this->clientApi->post('landing/validar_correo_empresa_landing', [
                'headers' => $this->getLandingHeaders(),
                'json'    => ['email_empresa' => $request->input('email_empresa')]
            ]);
            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Consultando el correo de la empresa, contacte a Soporte.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    public function pagoResultado(Request $request)
    {
        $idTransaccionWompi = $request->query('id');
        $estadoPago = 'PENDING';

        try {
            $response = \Illuminate\Support\Facades\Http::get(
                config('services.wompi.api_url') . '/transactions/' . $idTransaccionWompi
            );
            $data = $response->json();
            $estadoPago = $data['data']['status'] ?? 'PENDING';

        } catch (\Exception $e) {
            // \Illuminate\Support\Facades\Log::error('Error en pagoResultado: ' . $e->getMessage());
            Log::error('Error en pagoResultado: ' . $e->getMessage());
            $estadoPago = 'PENDING';
        }

        return view('wompi.checkout.resultado_pago', [
            'id_transaccion' => $idTransaccionWompi,
            'estado'         => $estadoPago,
        ]);
    } // FIN pagoResultado()

    // ======================================================================
    // ======================================================================

    public function notificarCorreoAsincrono(Request $request)
    {
        // 1. Validar token de seguridad interno para asegurar que solo tu API Lumen use este endpoint
        if ($request->header('X-Storedimo-Token') !== config('services.app_web.internal_token')) {
            Log::warning('Wompi Mail Webhook: Token no autorizado');
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $idSuscripcion = $request->input('id_suscripcion');
        $idTransaccion = $request->input('id_transaccion');
        $estadoWompi   = $request->input('estado_wompi');

        Log::info("Iniciando notificarCorreoAsincrono - Suscripción: {$idSuscripcion}, Estado: {$estadoWompi}");

        try {
            // 2. Preferir datos enviados por el webhook de la API (evita segunda llamada protegida)
            $empresa = $this->toMailObject($request->input('empresa'));
            $suscripcion = $this->toMailObject($request->input('suscripcion'));

            // Fallback: consultar landing solo si el webhook no mandó el payload completo
            if (!$suscripcion || !isset($suscripcion->id_empresa_suscrita)) {
                $reqSuscripcion = $this->clientApi->get('landing/suscripcion_edit_landing/' . $idSuscripcion, [
                    'headers' => $this->getLandingHeaders(),
                ]);
                $suscripcion = json_decode($reqSuscripcion->getBody()->getContents());
            }

            if (!$suscripcion || !isset($suscripcion->id_empresa_suscrita)) {
                Log::error("Wompi Mail Error: No se encontró la suscripción ID {$idSuscripcion}");
                return response()->json(['error' => 'Suscripción no válida'], 404);
            }

            if (!$empresa || !isset($empresa->email_empresa)) {
                $reqEmpresa = $this->clientApi->get('landing/empresa_edit_landing/' . $suscripcion->id_empresa_suscrita, [
                    'headers' => $this->getLandingHeaders(),
                ]);
                $empresa = json_decode($reqEmpresa->getBody()->getContents());
            }

            if (!$empresa || !isset($empresa->email_empresa)) {
                Log::error("Wompi Mail Error: No se encontraron datos de la empresa ID {$suscripcion->id_empresa_suscrita}");
                return response()->json(['error' => 'Empresa no encontrada'], 404);
            }

            $destinatarios = array_values(array_filter([
                config('mail.from.address'),
                'softdimo@gmail.com',
            ]));

            // 3. Envío de correos según el estado
            if ($estadoWompi === 'APPROVED') {
                Mail::send(
                    'emails.wompi.pago_aprobado_cliente',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($empresa) {
                        $m->to($empresa->email_empresa, $empresa->nombre_empresa ?? '')
                            ->subject('¡Pago aprobado! Bienvenido a Storedimo');
                    }
                );

                Mail::send(
                    'emails.wompi.pago_aprobado_admin',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($destinatarios) {
                        $m->to($destinatarios, 'Administrador Storedimo')
                            ->subject('Suscripción aprobada (Asíncrona vía API) - ' . now()->format('d/m/Y H:i'));
                    }
                );

                Log::info("Correos de APROBADO enviados a {$empresa->email_empresa} y Admins");

            } elseif (in_array($estadoWompi, ['DECLINED', 'VOIDED', 'ERROR'], true)) {
                Mail::send(
                    'emails.wompi.pago_fallido_cliente',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($empresa) {
                        $m->to($empresa->email_empresa, $empresa->nombre_empresa ?? '')
                            ->subject('Tu pago no pudo ser procesado - Storedimo');
                    }
                );

                Mail::send(
                    'emails.wompi.pago_fallido_admin',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($destinatarios) {
                        $m->to($destinatarios, 'Administrador Storedimo')
                            ->subject('Pago fallido cliente (Asíncrónica vía API) - ' . now()->format('d/m/Y H:i'));
                    }
                );

                Log::info("Correos de RECHAZADO enviados a {$empresa->email_empresa} y Admins");

            } elseif ($estadoWompi === 'PENDING') {
                Mail::send(
                    'emails.wompi.pago_pendiente_cliente',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($empresa) {
                        $m->to($empresa->email_empresa, $empresa->nombre_empresa ?? '')
                            ->subject('Tu pago está en verificación - Storedimo');
                    }
                );

                Mail::send(
                    'emails.wompi.pago_pendiente_admin',
                    ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                    function ($m) use ($destinatarios) {
                        $m->to($destinatarios, 'Administrador Storedimo')
                            ->subject('Pago pendiente cliente (Asíncrona vía API) - ' . now()->format('d/m/Y H:i'));
                    }
                );

                Log::info("Correos de PENDIENTE enviados a {$empresa->email_empresa} y Admins");
            } else {
                Log::warning("Wompi Mail: estado no contemplado para correo: {$estadoWompi}");
            }

            return response()->json(['success' => true, 'message' => 'Correos despachados correctamente'], 200);

        } catch (Exception $e) {
            Log::error('Error enviando correos asíncronos en App Web: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar correos'], 500);
        }
    }

    /**
     * Normaliza arrays/objetos del webhook a stdClass para las vistas Blade.
     */
    private function toMailObject($data): ?object
    {
        if (empty($data)) {
            return null;
        }

        if (is_object($data)) {
            return $data;
        }

        if (is_array($data)) {
            return json_decode(json_encode($data));
        }

        return null;
    }
    
    // ======================================================================
    // ======================================================================

    public function reintentarPago($idEmpresa)
    {
        try {
            // Consultar empresa
            $reqEmpresa = $this->clientApi->get($this->baseUri.'landing/empresa_edit_landing/' . $idEmpresa, [
                'headers' => $this->getLandingHeaders(),
            ]);
            $empresa = json_decode($reqEmpresa->getBody()->getContents());

            // Consultar suscripción más reciente de esa empresa
            $reqSuscripcion = $this->clientApi->get($this->baseUri.'landing/suscripcion_empresa_estado_login/' . $idEmpresa, [
                'headers' => $this->getLandingHeaders(),
            ]);
            $suscripcion = json_decode($reqSuscripcion->getBody()->getContents());

            $valorSuscripcion = $suscripcion->valor_suscripcion;
            $valorEnCentavos = intval($valorSuscripcion * 100);
            $referencia = "STOR-" . $suscripcion->id_suscripcion . "-" . time();

            $secretoIntegridad = config('services.wompi.integrity_secret');
            $cadenaFirma = $referencia . $valorEnCentavos . "COP" . $secretoIntegridad;
            $firmaHash = hash('sha256', $cadenaFirma);

            return view('wompi.checkout.pago_wompi', [
                'valor'         => $valorEnCentavos,
                'referencia'    => $referencia,
                'firma'         => $firmaHash,
                'email'         => $empresa->email_empresa,
                'nombre'        => $empresa->nombre_empresa,
                'celular'       => $empresa->celular_empresa,
                'publicKey'     => config('services.wompi.public_key')
            ]);

        } catch (\Exception $e) {
            alert()->error('Error', 'No fue posible recuperar los datos del pago.');
            return redirect()->route('inicio_sesion.login');
        }
    }

    // ======================================================================
    // ======================================================================

} // FIN class EmpresasController
