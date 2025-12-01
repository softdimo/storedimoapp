<?php

namespace App\Http\Controllers\suscripciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Responsable\suscripciones\SuscripcionIndex;
use App\Http\Responsable\suscripciones\SuscripcionStore;
use App\Http\Responsable\suscripciones\SuscripcionEdit;
use App\Http\Responsable\suscripciones\SuscripcionUpdate;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class SuscripcionesController extends Controller
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
                    $vista = new SuscripcionIndex();
                    return $this->validarAccesos($sesion[0], 68, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Suscripciones!");
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
                    $vista = 'suscripciones.create';
                    return $this->validarAccesos($sesion[0], 69, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Suscripciones!");
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
                    $vista = new SuscripcionStore();
                    return $this->validarAccesos($sesion[0], 70, $vista);
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

    public function edit(Request $request, $idUsuario)
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
                    // return new SuscripcionEdit($idUsuario);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Edit Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function update(Request $request, $idUsuario)
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
                    // $vista = new SuscripcionUpdate();
                    // return $this->validarAccesos($sesion[0], 10, $vista);
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
