<?php

namespace App\Http\Controllers\productos;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\productos\ProductoIndex;
use App\Http\Responsable\productos\ProductoStore;
use App\Http\Responsable\productos\ProductoShow;
use App\Http\Responsable\productos\ProductoEdit;
use App\Http\Responsable\productos\ProductoUpdate;
use App\Http\Responsable\productos\ProductoDestroy;
use App\Http\Responsable\productos\ProductoQueryBarCode;
use App\Http\Responsable\productos\ProductoGenerarBarCode;
use App\Http\Responsable\productos\ReporteProductosPdf;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class ProductosController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
                    $vista = new ProductoIndex();
                    return $this->validarAccesos($sesion[0], 19, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Productos!");
            return back();
        }
    }

    // ======================================================================

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
                    $categorias = $this->categoriasTrait();
                    $umd = $this->UmdTrait();
                    $proveedores = $this->proveedoresTrait();

                    view()->share('categorias', $categorias);
                    view()->share('umd', $umd);
                    view()->share('proveedores', $proveedores);

                    $vista = 'productos.create';
                    return $this->validarAccesos($sesion[0], 20, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Productos!");
            return back();
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

                    $vista = new ProductoStore();
                    return $this->validarAccesos($sesion[0], 27, $vista);
                }
            }
        } catch (Exception $e)
        {
            dd($e);
            alert()->error("Exception Store Productos!");
            return back();
        }
    }

    // ======================================================================

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idProducto)
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
                    $vista = new ProductoShow();
                    return $this->validarAccesos($sesion[0], 21, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Show Productos!");
            return back();
        }
    }

    // ======================================================================

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idProducto)
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
                    $categorias = $this->categoriasTrait();
                    $umd = $this->UmdTrait();
                    $proveedores = $this->proveedoresTrait();
                    return new ProductoEdit($idProducto, $categorias, $umd, $proveedores);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Edit Productos!");
            return back();
        }
    }

    // ======================================================================

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
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
                    $vista = new ProductoUpdate();
                    return $this->validarAccesos($sesion[0], 28, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Update Productos!");
            return back();
        }
    }

    // ======================================================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try
        {
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
                    $vista = new ProductoDestroy();
                    return $this->validarAccesos($sesion[0], 29, $vista);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception Destroy Productos!");
            return back();
        }
    }

    // ======================================================================

    public function verificarProducto(Request $request)
    {
        try
        {
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
                } else {
                    $baseUri = env('BASE_URI');
                    $clientApi = new Client(['base_uri' => $baseUri]);

                    try {
                        $nombreProducto = request('nombre_producto', null);
                        $idCategoria = request('id_categoria', null);

                        $verificarProducto = $clientApi->post($baseUri.'verificar_producto', [
                            'query' => [
                                'nombre_producto' => $nombreProducto,
                                'id_categoria' => $idCategoria,
                                'empresa_actual' => session('empresa_actual.id_empresa')
                            ]
                        ]);
                        
                        $resVerificarProducto = json_decode($verificarProducto->getBody()->getContents());
        
                        if( isset($resVerificarProducto) && !empty($resVerificarProducto) && !is_null($resVerificarProducto) ) {
                            return response()->json('existe_producto');
                        }
                    } catch (Exception $e) {
                        return response()->json('error_exception');
                    }
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Verificar producto!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    
    public function queryBarCodeProducto($idProducto)
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
                    $vista = new ProductoQueryBarCode($idProducto);
                    return $this->validarAccesos($sesion[0], 30, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Query BarCode Productos!");
            return back();
        }
    }

    // ======================================================================
        
    public function productoGenerarBarCode()
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
                    $vista = new ProductoGenerarBarCode;
                    return $this->validarAccesos($sesion[0], 30, $vista);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception GenerarBarCode Productos!");
            return back();
        }
    }
    
    // ======================================================================

    public function queryValoresProducto()
    {
        $idProducto = request('id_producto', null);

        try
        {
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
                    $queryValoresProducto = $this->clientApi->get($this->baseUri.'query_producto_update/'.$idProducto, [
                        'query' => [
                            'empresa_actual' => session('empresa_actual.id_empresa')
                        ]
                    ]);
                    return json_decode($queryValoresProducto->getBody()->getContents());
                }
            }
        } catch (Exception $e) {
            alert()->error("Error consultando los precios de los productos!");
            return back();
        }
    }
    
    // ======================================================================
        
    public function reporteProductosPdf()
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
                    $vista = new ReporteProductosPdf;
                    return $this->validarAccesos($sesion[0], 31, $vista);
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception ReporteProductosPdf!");
            return back();
        }
    }
    
    // ======================================================================

    /**
     * Valida que el campo de referencia sea único y no exista ya.
     *
     * @param Request $request Contiene el campo 'referencia' a validar
     * @return \Illuminate\Http\JsonResponse Retorna JSON indicando si la referencia es válida o ya está registrada
     */
    public function referenceValidator(Request $request)
    {
        try
        {
            $request->validate([
                'referencia' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z0-9_-]+$/',
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valido' => false,
                'error' => 'La referencia no tiene un formato válido.'
            ], 422);
        }

        try
        {
            $response = $this->clientApi->post($this->baseUri . 'verificar_referencia', [
                'json' => [
                    'referencia' => $request->input('referencia'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            return response()->json(json_decode($response->getBody()->getContents(), true));
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => 'No ha sido posible validar la referencia',
                'valido' => false
            ], 500);
        }
    }
    
    // ======================================================================

    public function categoriasTrait()
    {
        try {
            $response = $this->clientApi->get('categorias_trait', [
                'query' => ['empresa_actual' => session('empresa_actual.id_empresa')]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo categorías');
            return back();
        }
    }

    
    public function UmdTrait()
    {
        try
        {
            $response = $this->clientApi->get('umd_trait', [
                'query' => ['empresa_actual' => session('empresa_actual.id_empresa')]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e)
        {
            alert()->error('Error', 'Error obteniendo unidades de medida');
            return back();
        }
    }

    public function proveedoresTrait()
    {
        try
        {
            $response = $this->clientApi->get('proveedores_trait', [
                'query' => ['empresa_actual' => session('empresa_actual.id_empresa')]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e)
        {
            alert()->error('Error', 'Error obteniendo listado de proveedores');
            return back();
        }
    }
}
