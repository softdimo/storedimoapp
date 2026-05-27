<?php

namespace App\Http\Controllers\empresa_suscripcion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MetodosTrait;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Responsable\empresa_suscripcion\EmpresaSuscripcionStore;
use Illuminate\Support\Facades\Log;

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
            dd($e);
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
        $empresa = null;
        $suscripcion = null;

        try {
            $response = \Illuminate\Support\Facades\Http::get(
                config('services.wompi.api_url') . '/transactions/' . $idTransaccionWompi
            );
            $data = $response->json();
            $estadoPago = $data['data']['status'] ?? 'PENDING';

            // Extraer id_suscripcion de la referencia STOR-{id}-{timestamp}
            $referencia = $data['data']['reference'] ?? null;
            if ($referencia) {
                $partes = explode('-', $referencia);
                $idSuscripcion = $partes[1] ?? null;

                if ($idSuscripcion) {
                    // $reqSuscripcion = $this->getHttpClient()->get('administracion/suscripcion_edit/' . $idSuscripcion);
                    $reqSuscripcion = $this->clientApi->get($this->baseUri.'administracion/suscripcion_edit/' . $idSuscripcion);
                    $suscripcion = json_decode($reqSuscripcion->getBody()->getContents());

                    // $reqEmpresa = $this->getHttpClient()->get('administracion/empresa_edit/' . $suscripcion->id_empresa_suscrita);
                    $reqEmpresa = $this->clientApi->get($this->baseUri.'administracion/empresa_edit/' . $suscripcion->id_empresa_suscrita);
                    $empresa = json_decode($reqEmpresa->getBody()->getContents());
                }
            }

            // Enviar correos según estado
            if ($empresa && $suscripcion) {
                if ($estadoPago === 'APPROVED') {
                    // Correo al cliente
                    \Illuminate\Support\Facades\Mail::send(
                        'emails.wompi.pago_aprobado_cliente',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccionWompi],
                        function ($m) use ($empresa) {
                            $m->to($empresa->email_empresa, $empresa->nombre_empresa)
                            ->subject('¡Pago aprobado! Bienvenido a Storedimo, en breve que habilitamos su acceso');
                        }
                    );

                    // Correo al administrador Pago exitoso
                    \Illuminate\Support\Facades\Mail::send(
                        'emails.wompi.pago_aprobado_admin',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccionWompi],
                        function ($m) {
                            $m->to(config('mail.from.address'), 'Administrador Storedimo')
                            ->subject('Nueva suscripción aprobada - ' . now()->format('d/m/Y H:i'));
                        }
                    );

                } elseif (in_array($estadoPago, ['DECLINED', 'ERROR', 'VOIDED'])) {
                    // Correo al cliente avisando fallo
                    \Illuminate\Support\Facades\Mail::send(
                        'emails.wompi.pago_fallido_cliente',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccionWompi],
                        function ($m) use ($empresa) {
                            $m->to($empresa->email_empresa, $empresa->nombre_empresa)
                            ->subject('Tu pago no fue procesado - Storedimo');
                        }
                    );

                    // Correo al administrador Pago FALLIDO
                    \Illuminate\Support\Facades\Mail::send(
                        'emails.wompi.pago_fallido_admin',
                        ['empresa' => $empresa, 'suscripcion' => $suscripcion, 'idTransaccion' => $idTransaccionWompi],
                        function ($m) {
                            $m->to(config('mail.from.address'), 'Administrador Storedimo')
                            ->subject('Pago fallido ciente - ' . now()->format('d/m/Y H:i'));
                        }
                    );
                }
            }

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

    public function reintentarPago($idEmpresa)
    {
        try {
            // Consultar empresa
            // $reqEmpresa = $this->getHttpClient()->get('administracion/empresa_edit/' . $idEmpresa);
            $reqEmpresa = $this->clientApi->get($this->baseUri.'administracion/empresa_edit/' . $idEmpresa);
            $empresa = json_decode($reqEmpresa->getBody()->getContents());

            // Consultar suscripción más reciente de esa empresa
            // $reqSuscripcion = $this->getHttpClient()->get('administracion/suscripcion_empresa_estado_login/' . $idEmpresa);
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
