<?php

namespace App\Http\Controllers\informe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MetodosTrait;
use App\Http\Responsable\Informes\RespuestaInforme;
use App\Models\InformeCampo;
use App\Models\Informe;

class InformeController extends Controller
{
    use MetodosTrait;

    public function __construct()
    {
        $this->shareData();
    }

    public function informeGerencialUsuarios()
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
                    $vista = "informe_gerencial";
                   return $this->validarAccesos($sesion[0], 58, $vista, 1);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Informe Gerencial Usuarios!");
            return back();
        }
    }

    public function respuesta(Request $request): RespuestaInforme
    {
        return new RespuestaInforme();
    }
}
