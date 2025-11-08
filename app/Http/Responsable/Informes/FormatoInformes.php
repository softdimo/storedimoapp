<?php

namespace App\Http\Responsable\Informes;

use App\Models\Informe;
use Jenssegers\Date\Date;
use App\Models\InformeCampo;
use App\Traits\CamposInforme;
use App\Models\InformeInnerJoin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Exception;

/**
 * Formatea los datos enviados y responde con una tabla en html
 */
class FormatoInformes
{
    use CamposInforme;

    public $excel;

    public function __construct($excel = false)
    {
        $this->excel = $excel;
    }

    public function carga($datos)
    {
        try
        {
            if (array_key_exists('checkbox', $datos))
            { //verifica si algun check esta seleccionado
                $keys = array();
                $reqFiltro = array();
                $reqChecks = $datos['checkbox']; //se obtienen los checks
                $innerJoinPrincipal = "";
                $groupByPrincipal = "";
                $links = array();
                $idsJoins = array();
                if (array_key_exists('filtro', $datos))
                { //verifica si contiene algun filtro y obtiene los keys y valores
                    foreach ($datos['filtro'] as $key => $value)
                    {
                        if ($value != "-1" && $value != "")
                        {
                            array_push($keys, $key);
                            $reqFiltro[$key] = $value;
                            $joins = InformeInnerJoin::select('id', 'inner_join')
                                ->where('infxcampos', 'like', "%|" . $key . "|%")->orderBy('id')->get();
                            if (!empty($joins))
                            {
                                foreach ($joins as $join)
                                {
                                    $innerJoinPrincipal .= in_array($join->id, $idsJoins) ? "" : $join->inner_join . " "; //concatena todos los inner_join
                                    array_push($idsJoins, $join->id);
                                }
                            }
                        }
                    }
                }

                foreach ($reqChecks as $value)
                { //recorre todos los checks y consulta los inner_join que esten relacionados
                    $joins = InformeInnerJoin::select('id', 'inner_join')
                        ->where('infxcampos', 'like', "%|" . $value . "|%")->orderBy('id')->get();
                    if (!empty($joins))
                    {
                        foreach ($joins as $join)
                        {
                            $innerJoinPrincipal .= in_array($join->id, $idsJoins) ? "" : $join->inner_join . " "; //concatena todos los inner_join
                            array_push($idsJoins, $join->id);
                        }
                    }
                }
                //consultas
                $filtros = InformeCampo::orderBy('filtro_orden', 'ASC')
                                        ->find($keys); //consulta la informacion de los filtros
                $checkbox = InformeCampo::orderBy('campo_orden', 'ASC')
                                        ->find($reqChecks); //consulta la informacion de los checkbox
                $informe = Informe::where('informe_codigo', $checkbox[0]->informe_codigo)
                                    ->first(); //se obtiene el nombre de la tabla
                $titulos = $checkbox->pluck('informe_descripcion')->toArray(); //se obtienen los titulos
                $indices = array();
                //fin consultas
                $select = trim(implode(',', $checkbox->pluck('select_sql')->toArray()), ','); //prepara los select los separa por comas y quita la ultima
                $groupBy = $checkbox->where('campo_agrupar', true)
                                    ->pluck('select_sql')
                                    ->toArray(); //obtiene de los checks los campos que se puedan agrupar

                foreach ($groupBy as $value)
                {
                    if (($pos = strpos($value, ' AS ')) == 0) {
                        $nombreDB = $value;
                    } else {
                        $nombreDB = substr($value, $pos + 4);
                    }
                    $groupByPrincipal .= $nombreDB . ','; //los va agrupando y sepeandolos por coma
                }
                $cam_select_sql = $checkbox->pluck('select_sql')->toArray(); //obtiene los selects para armar los incides que se utilizan para los campos
                foreach ($cam_select_sql as $key => $value)
                {
                    if (($pos = strpos($value, ' AS ')) == 0) {
                        $nombreDB = $value;
                    } else {
                        $nombreDB = substr($value, $pos + 4);
                    }
                    array_push($indices, $nombreDB);
                }
                $cam_link = $checkbox->where('campo_link')->pluck('select_sql', 'campo_link')->toArray(); // obtiene los campos que tengan links
                foreach ($cam_link as $key => $value)
                {
                    if (($pos = strpos($value, ' AS ')) == 0) {
                        $nombreDB = $value;
                    } else {
                        $nombreDB = substr($value, $pos + 4);
                    }

                    $links[$nombreDB] = $key;
                }

                $tipoCampos = $checkbox->pluck('campo_tipo')->toArray(); //tipos de campos para el switch
                $tabla = $informe ? $informe->tabla_principal : ""; //saca el nombre de la tabla
                $where_principal = $informe ? $informe->where_principal : ""; //where principal
                $groupByPrincipal = $groupByPrincipal == "" ? "" : substr_replace($groupByPrincipal, "GROUP BY ", 0, 0); //verifica si hay algun group by
                //contiene todos los resultados para la ejecucion de la consulta

                $checkboxInfxcamCodigo = $checkbox[0]->infxcam_codigo;

                $reglas = [
                    'queryPrincipal' => "SELECT {$select} FROM {$tabla} ",
                    'primerWhere' => $where_principal != "" ? false : true,
                    'where' => $where_principal,
                    'join' => $innerJoinPrincipal != "" ? $innerJoinPrincipal : "",
                    'groupBy' => trim($groupByPrincipal, ','),

                ];

                $reglas = $this->whereCkecks($checkbox, $reglas);

                foreach ($filtros as $filtro)
                {
                    switch ($filtro->filtro_tipo)
                    {
                        case 1:
                            $reglas = $this->inputSelect($reqFiltro, $filtro, $reglas, $informe);
                            break;
                        case 2:
                            $reglas = $this->inputFecha($reqFiltro, $filtro, $reglas);
                            break;
                        case 3:
                            $reglas = $this->inputRangoNumeros($reqFiltro, $filtro, $reglas);
                            break;
                        case 4:
                            $reglas = $this->inputText($reqFiltro, $filtro, $reglas);
                            break;
                        case 5:
                            $reglas = $this->inputFechaTimestamp($reqFiltro, $filtro, $reglas);
                            break;
                        case 6:
                            $reglas = $this->inputFechaDate($reqFiltro, $filtro, $reglas);
                            break;
                        case 8:
                            $reglas = $this->inputTextExacto($reqFiltro, $filtro, $reglas);
                            break;
                        case 9:
                            $reglas = $this->inputFechaDateCompareToDate($reqFiltro, $filtro, $reglas);
                            break;
                        default:
                            // $reglas = $this->inputFecha($reqFiltro, $llave, $reglas);
                            break;
                    }
                }

                $filas = $this->tabla($indices, $reglas, $tipoCampos, $links);
                if ($this->excel)
                { // si petición para generar archivo de excel realiza la tabla sin thead
                    $input = View::make('layouts.tabla_excel', ['titulos' => $titulos, 'indices' => $indices, 'filas' => $filas])->render();
                } else { //si es peticion para json
                    $input = View::make('layouts.tabla', ['titulos' => $titulos, 'indices' => $indices, 'filas' => $filas])->render();
                }

                return ['status' => true, 'input' => $input];
            }

            return ['status' => false];

        } catch (Exception $e)
        {
            logger()->error('Error en FormatoInformes: ' . $e->getMessage());
        }
    }

    /**
     * [tabla description]
     * @param array $indices [description]
     * @param array $reglas [description]
     * @param array $tipoCampos [description]
     * @param array $links [description]
     * @return view             [description]
     */
    private function tabla($indices, $reglas, $tipoCampos, $links)
    {
        $filas = "";
        $resultado = DB::cursor("{$reglas['queryPrincipal']} {$reglas['join']} {$reglas['where']} {$reglas['groupBy']}");
        $totales = array();
        $numeros = false;
        foreach ($resultado as $key => $value)
        {
            $is_date = new \StdClass();
            for ($j = 0; $j < count($indices); $j++)
            {
                $propiedad = $indices[$j];
                $link = "";
                if (!empty($links)) {
                    if (array_key_exists($propiedad, $links))
                    {
                        $temp = explode("#", $links[$propiedad]);
                        if (isset($temp[1])) {
                            $nombreLink = $temp[1];
                            if ($nombreLink != '') {
                                $link = preg_replace('/{id}/', $value->$propiedad, $temp[0]);
                                $link = preg_replace('/{nombre}/', $nombreLink, $link);
                                $link = preg_replace('/{id}/', $value->$propiedad, $link);
                            }
                        } else {
                            $nombreLink = $value->$propiedad;
                            if ($nombreLink != '') {
                                $link = preg_replace('/{id}/', $value->$propiedad, $temp[0]);
                                $link = preg_replace('/{nombre}/', $nombreLink, $link);
                                $link = preg_replace('/{id}/', $value->$propiedad, $link);
                            }
                        }
                    }
                }

                switch ($tipoCampos[$j])
                { //dependiendo del tipo de campo, se le formatea la información
                    case 1:
                        $value->$propiedad = ($link == "") ? $value->$propiedad : $link;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = null;
                        break;
                    case 2:
                        $numeros = true;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? ($totales[$indices[$j]] + $value->$propiedad) : $value->$propiedad;
                        $value->$propiedad = number_format($value->$propiedad);
                        $is_date->$propiedad = null;
                        break;
                    case 3:
                        if (!is_null($value->$propiedad)) {
                            $date = Date::parse((int)$value->$propiedad);
                            $value->$propiedad = $date->format("d-m-Y");
                            $is_date->$propiedad = $date->format("Ymd");
                        } else {
                            $value->$propiedad = "";
                            $is_date->$propiedad = null;
                        }
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    case 4:
                        if ($value->$propiedad != "") {
                            $date = Date::parse((int)$value->$propiedad);
                            $value->$propiedad = $date->format("d-m-Y");
                            $is_date->$propiedad = $date->format("Ymd");
                        } else {
                            $value->$propiedad = "";
                            $is_date->$propiedad = null;
                        }
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    case 6:
                        $value->$propiedad = strftime("%A, %d de %B de %Y", $value->$propiedad);
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = date("Ymd", $value->$propiedad);
                        break;
                    case 7:
                        $value->$propiedad = strftime("%B/%d/%y", $value->$propiedad);
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = date("Ymd", $value->$propiedad);
                        break;
                    case 8:
                        $numeros = true;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? ($totales[$indices[$j]] + $value->$propiedad) : $value->$propiedad;
                        $value->$propiedad = "$" . number_format($value->$propiedad);
                        $is_date->$propiedad = null;
                        break;
                    case 9:
                        $date = Date::parse((int)$value->$propiedad);
                        $value->$propiedad = $date->format("g:i A");
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = $date->format("Ymd");
                        break;
                    case 10: //devuelve solo el mes String
                        $value->$propiedad = title_case($value->$propiedad);
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = null;
                        break;
                    case 11:
                        $numeros = true;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? ($totales[$indices[$j]] + $value->$propiedad) : $value->$propiedad;
                        $value->$propiedad = "%" . number_format($value->$propiedad);
                        $is_date->$propiedad = null;
                        break;
                    case 13:
                        $numeros = true;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? ($totales[$indices[$j]] + $value->$propiedad) : $value->$propiedad;
                        $value->$propiedad = number_format($value->$propiedad, 2, '.', ',');
                        $is_date->$propiedad = null;
                        break;
                    case 14:
                        $numeros = true;
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? ($totales[$indices[$j]] + $value->$propiedad) : $value->$propiedad;
                        $value->$propiedad = number_format($value->$propiedad, 2, '.', '');
                        $is_date->$propiedad = null;
                        break;
                    case 15:
                        $value->$propiedad = nl2br($value->$propiedad);
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = null;
                        break;
                    case 16:
                        if ($value->$propiedad != "") {
                            $date = Date::parse((int)$value->$propiedad);
                            $value->$propiedad = $date->format("d/m/Y");
                            $is_date->$propiedad = $date->format("Ymd");
                        } else {
                            $value->$propiedad = "";
                            $is_date->$propiedad = null;
                        }
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    case 17:
                        $date = Date::parse($value->$propiedad);
                        $value->$propiedad = $date->format("Y-m-d");
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = $date->format("Ymd");
                        break;
                    case 18:
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    case 19:
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    case 20:
                        if (!is_null($value->$propiedad)) {
                            $date = Date::parse((int)$value->$propiedad);
                            $value->$propiedad = $date->format("d-m-Y H:i:s");
                            $is_date->$propiedad = $date->format("Ymd");
                        } else {
                            $value->$propiedad = "";
                            $is_date->$propiedad = null;
                        }
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        break;
                    default: // case 5, 12
                        $totales[$indices[$j]] = isset($totales[$indices[$j]]) ? null : null;
                        $is_date->$propiedad = null;
                        break;
                }
            }

            $fila = View::make('layouts.filas', ['indices' => $indices, 'fila' => $value, 'cantidades' => array(), 'is_date' => $is_date])->render();
            $filas .= $fila;

        }
        if ($this->excel)
        {
            return $filas;
        }

        $tfoot = View::make('layouts.tfoot', ['indices' => $indices, 'totales' => $totales, 'numeros' => $numeros])->render();
        return $filas . $tfoot;
    }
}
