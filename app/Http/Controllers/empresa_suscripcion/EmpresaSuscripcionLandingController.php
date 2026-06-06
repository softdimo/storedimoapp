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

class EmpresaSuscripcionLandingController extends Controller
{
    use MetodosTrait;

    public function __construct()
    {
        $this->shareData();
    }

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
            return new EmpresaSuscripcionStore($request);
                
        } catch (Exception $e)
        {
            alert()->error("Exception Store Empresas!");
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
                'valido' => false,
                'error' => $e->validator->errors()->first('nit_empresa')
            ], 422);
        }
    
        try {
            // $response = $this->getHttpClient()->post('administracion/validar_nit', [
            $response = $this->clientApi->post($this->baseUri.'administracion/validar_nit', [
                'json' => ['nit_empresa' => $request->input('nit_empresa')]
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
            // $response = $this->getHttpClient()->post('administracion/validar_documento', [
            $response = $this->clientApi->post($this->baseUri.'administracion/validar_documento', [
                'json' => ['ident_empresa_natural' => $request->input('ident_empresa_natural')]
            ]);
        
            return response()->json(json_decode($response->getBody()->getContents(), true));
        
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo validar el número del documento en la BD.',
                'valido' => false
            ], 500);
        }
    }

    // ======================================================================
    // ======================================================================

    public function validarCorreoEmpresaLanding(Request $request)
    {
        try {
            // $response = $this->getHttpClient()->post('administracion/validar_correo_empresa', [
            $response = $this->clientApi->post($this->baseUri.'administracion/validar_correo_empresa', [
                'json' => [
                    'email_empresa' => $request->input('email_empresa')
                ]
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
            \Illuminate\Support\Facades\Log::error('Error en pagoResultado: ' . $e->getMessage());
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
        // Validar token de seguridad interno para asegurar que solo tu API Lumen use este endpoint
        if ($request->header('X-Storedimo-Token') !== config('services.app_web.internal_token')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $idSuscripcion = $request->input('id_suscripcion');
        $idTransaccion = $request->input('id_transaccion');
        $estadoWompi   = $request->input('estado_wompi');

        try {
            // Consultamos a la API de Lumen los datos frescos de la suscripción y empresa mediante tu cliente regular
            $reqSuscripcion = $this->clientApi->get($this->baseUri . 'administracion/suscripcion_edit/' . $idSuscripcion);
            $suscripcion = json_decode($reqSuscripcion->getBody()->getContents());

            if (!$suscripcion) {
                return response()->json(['error' => 'Suscripción no válida'], 404);
            }

            $reqEmpresa = $this->clientApi->get($this->baseUri . 'administracion/empresa_edit/' . $suscripcion->id_empresa_suscrita);
            $empresa = json_decode($reqEmpresa->getBody()->getContents());

            if ($empresa) {
                if ($estadoWompi === 'APPROVED') {
                    // Enviar correos de Aprobado (Cliente y Admin)
                    Mail::send(
                        'emails.wompi.pago_aprobado_cliente',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                        function ($m) use ($empresa) {
                            $m->to($empresa->email_empresa, $empresa->nombre_empresa)
                            ->subject('¡Pago aprobado! Bienvenido a Storedimo');
                        }
                    );

                    \Illuminate\Support\Facades\Mail::send(
                        'emails.wompi.pago_aprobado_admin',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                        function ($m) {
                            $m->to(config('mail.from.address'), 'Administrador Storedimo')
                            ->subject('Suscripción aprobada (Asíncrona vía API) - ' . now()->format('d/m/Y H:i'));
                        }
                    );
                } elseif (in_array($estadoWompi, ['DECLINED', 'VOIDED', 'ERROR'])) {
                    // Enviar correos de Fallido (Cliente y Admin)
                    Mail::send(
                        'emails.wompi.pago_fallido_cliente',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                        function ($m) use ($empresa) {
                            $m->to($empresa->email_empresa, $empresa->nombre_empresa)
                            ->subject('Tu pago no pudo ser procesado - Storedimo');
                        }
                    );

                    Mail::send(
                        'emails.wompi.pago_fallido_admin',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccion],
                        function ($m) {
                            $m->to(config('mail.from.address'), 'Administrador Storedimo')
                            ->subject('Pago fallido cliente (Asíncrónica vía API) - ' . now()->format('d/m/Y H:i'));
                        }
                    );
                }
            }

            return response()->json(['success' => true, 'message' => 'Correos despachados'], 200);

        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando correos asíncronos en App Web: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar correos'], 500);
        }
    }
    
    // ======================================================================
    // ======================================================================

    public function reintentarPago($idEmpresa)
    {
        try {
            // Consultar empresa
            $reqEmpresa = $this->clientApi->get($this->baseUri.'administracion/empresa_edit/' . $idEmpresa);
            $empresa = json_decode($reqEmpresa->getBody()->getContents());

            // Consultar suscripción más reciente de esa empresa
            $reqSuscripcion = $this->clientApi->get($this->baseUri.'administracion/suscripcion_empresa_estado_login/' . $idEmpresa);
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
            return redirect()->route('home.index');
        }
    }

    // ======================================================================
    // ======================================================================

} // FIN class EmpresasController
