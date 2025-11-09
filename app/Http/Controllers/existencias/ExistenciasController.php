<?php

namespace App\Http\Controllers\existencias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\existencias\BajaIndex;
use App\Http\Responsable\existencias\BajaDetalle;
use App\Http\Responsable\existencias\BajaStore;
use App\Http\Responsable\existencias\ReporteBajasPdf;
use App\Http\Responsable\existencias\StockMinimo;
use App\Http\Responsable\existencias\FechasVencimiento;
use App\Http\Responsable\existencias\StockMinimoPdf;
use App\Http\Responsable\existencias\AlertaStockMinimo;
use App\Http\Responsable\existencias\AlertaFechaVencimiento;
class ExistenciasController extends Controller
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
        //
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
                    $productosData  = $this->productosTrait();
                    // dd($productos);

                    // Convertimos a formato para el Form::select
                    $productos = collect($productosData)->pluck('nombre_producto', 'id_producto');

                    // Compartimos ambos (el pluck y la lista completa)
                    // view()->share('productos', $productos);
                    view()->share(compact('productos', 'productosData'));

                    $vista = 'existencias.create';
                    return $this->validarAccesos($sesion[0], 13, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Existencias!");
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
        //
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

    public function baja($idBaja)
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
                    $vista = new BajaDetalle($idBaja);
                    return $this->validarAccesos($sesion[0], 14, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Bajas!");
            return redirect()->to(route('login'));
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
    public function update(Request $request, $id)
    {
        //
    }

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

    public function bajasIndex()
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
                    $vista = new BajaIndex();
                    return $this->validarAccesos($sesion[0], 14, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Bajas!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================

    public function bajaStore()
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
                    $vista = new BajaStore();
                    return $this->validarAccesos($sesion[0], 32, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception BajaStore Existencias!");
            return redirect()->to(route('login'));
        }
    }
    
    // ======================================================================

    public function reporteBajasPdf()
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
                    $vista = new ReporteBajasPdf();
                    return $this->validarAccesos($sesion[0], 33, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }
    
    // ======================================================================

    public function stockMinimo()
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
                    $vista = new StockMinimo();
                    return $this->validarAccesos($sesion[0], 34, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }

    public function fechasVencimiento()
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
                    $vista = new FechasVencimiento();
                    return $this->validarAccesos($sesion[0], 34, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception fechasVencimiento!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================

    public function stockMinimoPdf()
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
                    $vista = new StockMinimoPdf();
                    return $this->validarAccesos($sesion[0], 35, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }
    
    // ======================================================================

    public function alertaStockMinimo()
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
                    $vista = new AlertaStockMinimo();
                    return $this->validarAccesos($sesion[0], 37, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================

    public function productosTrait()
    {
        try {
            $response = $this->clientApi->get('productos_trait_existencias', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo productos en existencias');
            return back();
        }
    }
}
