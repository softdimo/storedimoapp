<?php

namespace App\Http\Controllers\entradas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\entradas\EntradaIndex;
use App\Http\Responsable\entradas\DetalleEntrada;
use App\Http\Responsable\entradas\EntradaStore;
use App\Http\Responsable\entradas\ReporteComprasPdf;
use App\Http\Responsable\entradas\DetalleComprasPdf;


class EntradasController extends Controller
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
                    $vista = new EntradaIndex();
                    return $this->validarAccesos($sesion[0], 38, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Entradas!");
            return redirect()->to(route('login'));
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

                    $productos_compras = $this->productosTraitCompras();
                    view()->share('productos_compras', $productos_compras);

                    $proveedores = $this->proveedoresTrait();
                    view()->share('proveedores_compras', $proveedores);

                    $vista = 'entradas.create';
                    return $this->validarAccesos($sesion[0], 36, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Existencias!");
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
                    $vista = new EntradaStore();
                    return $this->validarAccesos($sesion[0], 39, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Store Entradas!");
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

    public function anularCompra(Request $request)
    {
        $idCompra = request('id_compra', null);
        $motivoAnulacion = request('motivo', null);

        try
        {
            if(is_null($motivoAnulacion) || $motivoAnulacion == "")
            {
                alert()->error('Error', 'El motivo de anulación es obligatorio');
                return redirect()->to(route('entradas.index'));
            }

            $reqAnularCompra = $this->clientApi->post($this->baseUri.'anular_compra/'.$idCompra, [
                'json' => [
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa'),
                    'motivo' => $motivoAnulacion
                ]
            ]);
            $resAnularCompra = json_decode($reqAnularCompra->getBody()->getContents());

            if(isset($resAnularCompra) && !empty($resAnularCompra) && !is_null($resAnularCompra))
            {
                alert()->success('Proceso Exitoso', 'La compra ha sido anulada satisfactoriamente');
                return redirect()->to(route('entradas.index'));
            }
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception, contacte a Soporte.' . $e->getMessage());
            return back();
        }
    }
        
    // ======================================================================

    public function reporteComprasPdf()
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
                    $vista = new ReporteComprasPdf();
                    return $this->validarAccesos($sesion[0], 40, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================

    public function detalleComprasPdf($idCompra)
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
                    $vista = new DetalleComprasPdf($idCompra);
                    return $this->validarAccesos($sesion[0], 41, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception stockMinimo!");
            return redirect()->to(route('login'));
        }
    }

    public function entrada($idEntrada)
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
                    $vista = new DetalleEntrada($idEntrada);
                    return $this->validarAccesos($sesion[0], 38, $vista);
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

    public function productosTraitCompras()
    {
        try
        {
            $response = $this->clientApi->get('productos_trait_compras', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo productos en compras');
            return back();
        }
    }
    
    // ======================================================================
    // ======================================================================

    public function proveedoresTrait()
    {
        try {
            $response = $this->clientApi->get('proveedores_trait', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            alert()->error('Error', 'Error obteniendo proveedores');
            return [];
        }
    }

    public function productosPorProveedor(Request $request)
    {
        try
        {
            $response = $this->clientApi->get('productos_por_proveedor', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e)
        {
            return response()->json('error_exception');
        }
    }
}
