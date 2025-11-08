<?php

namespace App\Http\Controllers\empresas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\empresas\EmpresaIndex;
use App\Http\Responsable\empresas\EmpresaStore;
use App\Http\Responsable\empresas\EmpresaUpdate;
use App\Http\Responsable\empresas\EmpresaEdit;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class EmpresasController extends Controller
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->shareData();
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
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
        try
        {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new EmpresaIndex();
                    return $this->validarAccesos($sesion[0], 6, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Entradas!");
            return redirect()->to(route('login'));
        }
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
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = 'empresas.create';
                    return $this->validarAccesos($sesion[0], 4, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Empresas!");
            return redirect()->to(route('login'));
        }
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
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new EmpresaStore();
                    return $this->validarAccesos($sesion[0], 22, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Store Empresas!");
            return redirect()->to(route('login'));
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
        try {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new EmpresaEdit($idEmpresa);
                    return $this->validarAccesos($sesion[0], 12, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Editando la Empresa!");
            return redirect()->to(route('login'));
        }
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
        try {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new EmpresaUpdate($idEmpresa);
                    return $this->validarAccesos($sesion[0], 12, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Update Empresas!");
            return redirect()->to(route('login'));
        }
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

    public function nit_validator(Request $request)
    {
        try {
            $request->validate([
                'nit_empresa' => [
                    'required',
                    'regex:/^[0-9]{9}$/',
                ]
            ], [
                'nit_empresa.required' => 'El NIT es obligatorio.',
                'nit_empresa.regex'    => 'El NIT debe contener exactamente 9 dígitos numéricos.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valido' => false,
                'error' => $e->validator->errors()->first('nit_empresa') // mensaje específico
            ], 422);
        }
    
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/validar_nit', [
                'json' => [
                    'nit_empresa' => $request->input('nit_empresa')
                ]
            ]);
        
            return response()->json(
                json_decode($response->getBody()->getContents(), true)
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo validar el NIT en el servicio externo.',
                'valido' => false
            ], 500);
        }
    }

}
