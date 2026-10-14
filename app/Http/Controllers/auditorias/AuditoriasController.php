<?php

namespace App\Http\Controllers\auditorias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client;

use App\Http\Responsable\auditorias\AuditoriaIndex;
use App\Traits\MetodosTrait;

class AuditoriasController extends Controller
{
    use MetodosTrait;

    protected $baseUri;
    protected $clientApi;
    protected $jwtToken;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->shareData();
            $this->jwtToken = session('api_jwt_token');
            return $next($request);
        });

        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

       /* Helper privado para obtener las cabeceras estándar con JWT */
       private function getHeaders()
       {
           return [
               'Authorization' => 'Bearer ' . session('api_jwt_token'),
               'Accept'        => 'application/json',
           ];
       }
       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            }
            
            $sesion = $this->validarVariablesSesion();

            if (empty($sesion[0]) || is_null($sesion[0]) &&
                empty($sesion[1]) || is_null($sesion[1]) &&
                empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
            {
                return redirect()->to(route('login'));

            } else {
                $vista = new AuditoriaIndex();
                return $this->validarAccesos($sesion[0], 87, $vista);
            }

        } catch (Exception $e) {
            alert()->error("Exception Index Auditorias!");
            return back();
        }
    }

    /**
     * Página de auditorías para DataTables.
     * El navegador envía start y length; aquí se reenvían a la API.
     */
    public function datos(Request $request)
    {
        try {
            $sesion = $this->validarVariablesSesion();

            if (empty($sesion[0]) || is_null($sesion[0])) {
                return response()->json(['message' => 'Sesión no válida'], 401);
            }

            $permisosUsuario = $this->permisosPorUsuario($sesion[0]);

            if (!in_array(87, (array) $permisosUsuario)) {
                return response()->json(['message' => 'Sin permiso'], 403);
            }

            $response = $this->clientApi->get('administracion/auditoria_index', [
                'headers' => $this->getHeaders(),
                'query' => [
                    'draw'   => $request->input('draw'),
                    'start'  => $request->input('start', 0),
                    'length' => $request->input('length', 10),
                ],
            ]);

            return response($response->getBody()->getContents(), 200)
                ->header('Content-Type', 'application/json');

        } catch (Exception $e) {
            return response()->json([
                'draw'            => (int) $request->input('draw'),
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'error'           => 'No fue posible consultar las auditorías',
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
