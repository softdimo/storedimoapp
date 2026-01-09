<?php

namespace App\Http\Controllers\proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\proveedores\ProveedorIndex;
use App\Http\Responsable\proveedores\ProveedorStore;
use App\Http\Responsable\proveedores\ProveedorUpdate;
use App\Http\Responsable\proveedores\ProveedorEdit;
use Exception;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;


class ProveedoresController extends Controller
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
    public function index(Request $request)
    {
        try
        {
            if (!$this->checkDatabaseConnection()) {
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
                    $vista = new ProveedorIndex();
                    return $this->validarAccesos($sesion[0], 7, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Proveedor!");
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
                    $this->shareData();

                    $vista = 'proveedores.create';
                    return $this->validarAccesos($sesion[0], 8, $vista);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception Create Proveedor!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
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
                    $vista = new ProveedorStore();
                    return $this->validarAccesos($sesion[0], 26, $vista);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception Store Proveedor!");
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
    public function edit($idProveedor)
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
                } else {
                    return new ProveedorEdit($idProveedor);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception Store Proveedor!");
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
    public function update(Request $request, $id)
    {
        try {
            if (!$this->checkDatabaseConnection())
            {
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
                    $vista = new ProveedorUpdate();
                    return $this->validarAccesos($sesion[0], 15, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Update Proveedor!");
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
    
    // ======================================================================
    // ======================================================================

    public function validarCorreoProveedor(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'validar_correo_proveedor', [
                'json' => [
                    'email_proveedor' => $request->input('email_proveedor')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Consultando el correo del proveedor, contacte a Soporte.');
            return back();
        }
    }
}
