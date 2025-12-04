<?php

namespace App\Http\Controllers\planes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Responsable\planes\PlanIndex;
use App\Http\Responsable\planes\PlanStore;
use App\Http\Responsable\planes\PlanEdit;
use App\Http\Responsable\planes\PlanUpdate;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class PlanesController extends Controller
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

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new PlanIndex();
                    return $this->validarAccesos($sesion[0], 74, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Planes!");
            return redirect()->to(route('login'));
        }
    }

    public function create()
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    // Llama al método del trait para cargar empresas disponibles
                    $this->shareEmpresasSuscripciones(null);
                    // ==============================

                    $vista = 'planes.create';
                    return $this->validarAccesos($sesion[0], 69, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Planes!");
            return redirect()->to(route('login'));
        }
    }

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

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    // $vista = new PlanStore();
                    // return $this->validarAccesos($sesion[0], 70, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Store Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $idSuscripcion)
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    // $vista = new PlanEdit($idSuscripcion);
                    // return $this->validarAccesos($sesion[0], 71, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Edit Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function update(Request $request, $idSuscripcion)
    {
        try
        {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    // $vista = new PlanUpdate($idSuscripcion);
                    // return $this->validarAccesos($sesion[0], 72, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Update Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function destroy($id)
    {
        //
    }
}
