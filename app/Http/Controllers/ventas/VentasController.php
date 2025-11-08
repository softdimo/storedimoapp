<?php

namespace App\Http\Controllers\ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\ventas\VentaIndex;
use App\Http\Responsable\ventas\DetalleVenta;
use App\Http\Responsable\ventas\VentaStore;
use App\Http\Responsable\ventas\ReporteVentasPdf;
use App\Http\Responsable\ventas\ReciboCajaVenta;

class VentasController extends Controller
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
                    $vista = new VentaIndex();
                    return $this->validarAccesos($sesion[0], 43, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Ventas!");
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
                    $categorias = $this->categoriasTrait();
                    view()->share('categorias', $categorias);

                    $clientes = $this->clientesTrait();
                    view()->share('clientes_ventas', $clientes);

                    $productos = $this->productosTrait();
                    view()->share('productos', $productos);

                    $vista = 'ventas.create';
                    return $this->validarAccesos($sesion[0], 44, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Ventas!");
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
                    $vista = new VentaStore();
                    return $this->validarAccesos($sesion[0], 45, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Store Ventas!");
            return redirect()->to(route('login'));
        }
    }

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
    public function edit($id)
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
    public function update(Request $request, $id)
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

    public function listarCreditoVentas()
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
                } else
                {
                    $vista = 'ventas.credito_ventas';
                    return $this->validarAccesos($sesion[0], 46, $vista);
                    
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Ventas!");
            return redirect()->to(route('login'));
        }
    }
            
    // ======================================================================

    public function reporteVentasPdf()
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
                } else
                {
                    $vista = new ReporteVentasPdf();
                    return $this->validarAccesos($sesion[0], 47, $vista);
                    
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Reporte Ventas Pdf!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================

    public function reciboCajaVenta()
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
                } else
                {
                    $vista = new ReciboCajaVenta();
                    return $this->validarAccesos($sesion[0], 48, $vista);
                    
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception ReciboCajaVenta!");
            return redirect()->to(route('login'));
        }
    }

    public function detalleVentas($idVenta)
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
                } else
                {
                    $vista = new DetalleVenta($idVenta);
                    return $this->validarAccesos($sesion[0], 48, $vista);
                    
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception ReciboCajaVenta!");
            return redirect()->to(route('login'));
        }
    }
            
    // ======================================================================
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

    // ======================================================================
    // ======================================================================

    public function clientesTrait()
    {
        try {
            $response = $this->clientApi->get('clientes_trait', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo clientes');
            return [];
        }
    }

    // ======================================================================
    // ======================================================================

    public function productosTrait()
    {
        try {
            $response = $this->clientApi->get('productos_trait_ventas', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo productos en ventas');
            return back();
        }
    }
}
