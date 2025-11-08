<?php

namespace App\Traits;

use Carbon\Carbon;
use Jenssegers\Date\Date;

/**
 * Filtros para la consultas de los informes
 */
trait CamposInforme
{
    /**
     * [formatoDiaMes description]
     * @param  [type] $valor [description]
     * @return void [type]        [description]
     */
    public function formatoDiaMes($valor)
    {

    }

    /**
     * Cuando los campos del informe son checkbox
     * @param $checkbox
     * @param $reglas
     * @return mixed [type]           [description]
     */
    public function whereCkecks($checkbox, $reglas)
    {
        $where_checks = $checkbox->where('where_sql', '!=', null)
                        ->pluck('where_sql')
                        ->toArray();

        foreach ($where_checks as $key => $value)
        {
            if ($reglas['primerWhere']) {
                $reglas['where'] = " WHERE {$value}";
                $reglas['primerWhere'] = false;
            } else {
                $reglas['where'] .= " AND {$value}";
            }
        }
        return $reglas;
    }

    /**
     * Cuando los campos del informe son selects
     * @param $reqFiltro
     * @param $filtro
     * @param $reglas
     * @return mixed [type]            [description]
     */
    public function inputSelect($reqFiltro, $filtro, $reglas, $informe)
    {

        if ($reglas['primerWhere'])
        {
            if ($reqFiltro[$filtro->id] == -999)
            {
                $reglas['where'] = " WHERE {$filtro->campo_filtro_where} IS NULL";
            } else
            {
                $reglas['where'] = " WHERE {$filtro->campo_filtro_where} = '{$reqFiltro[$filtro->id]}'";
            }
            $reglas['primerWhere'] = false;
        } else
        {
            if ($reqFiltro[$filtro->id] == -999)
            {
                $reglas['where'] .= " AND {$filtro->campo_filtro_where} IS NULL";
            } else
            {
                $reglas['where'] .= " AND {$filtro->campo_filtro_where} = '{$reqFiltro[$filtro->id]}'";
            }
        }

        return $reglas;
    }

    /**
     * [inputFechaTimestamp description]
     * @param $reqFiltro
     * @param $filtro
     * @param $reglas
     * @return mixed [type]            [description]
     */
    public function inputFechaTimestamp($reqFiltro, $filtro, $reglas)
    {
        list($fecha_inicio, $fecha_fin) = explode(' - ' , $reqFiltro[$filtro->id]);

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_fin = str_replace('/', '-', $fecha_fin);

        $inicial = new Date("{$fecha_inicio} 00:00:00");
        $final = new Date("{$fecha_fin} 23:59:59");

        // $fechas = explode(' - ', $reqFiltro[$filtro->infxcam_codigo]);
        // $inicial = new Date($fechas[0]." 00:00:00");
        // $final = new Date($fechas[1]." 23:59:59");

        if ($reglas['primerWhere']) {
            $reglas['where'] = " WHERE {$filtro->campo_filtro_where} BETWEEN '{$inicial->timestamp}' AND '{$final->timestamp}'";
            $reglas['primerWhere'] = false;
        } else {
            $reglas['where'] .= " AND {$filtro->campo_filtro_where} BETWEEN '{$inicial->timestamp}' AND '{$final->timestamp}'";
        }
        return $reglas;
    }

    /**
     * [inputFechaDate description]
     * @param  [type] $reqFiltro [description]
     * @param  [type] $filtro    [description]
     * @param  [type] $reglas    [description]
     * @return [type]            [description]
     */
    public function inputFechaDate($reqFiltro, $filtro, $reglas)
    {
        $fechas = explode(' - ', $reqFiltro[$filtro->id]);
       
        $inicial = Carbon::parse(str_replace('/', '-', $fechas[0]))->startOfDay();
        $final = Carbon::parse(str_replace('/', '-', $fechas[1]))->endOfDay();

        if ($reglas['primerWhere']) {
            $reglas['where'] = " WHERE {$filtro->campo_filtro_where} BETWEEN '{$inicial}'::date AND '{$final}'::date";
            $reglas['primerWhere'] = false;
        } else {
            $reglas['where'] .= " AND {$filtro->campo_filtro_where} BETWEEN '{$inicial}'::date AND '{$final}'::date";
        }

        return $reglas;
    }

     /**
     * [inputFechaDate description]
     * @param  [type] $reqFiltro [description]
     * @param  [type] $filtro    [description]
     * @param  [type] $reglas    [description]
     * @return [type]            [description]
     */
    public function inputFechaDateCompareToDate($reqFiltro, $filtro, $reglas)
    {
        list($fecha_inicio, $fecha_fin) = explode(' - ' , $reqFiltro[$filtro->id]);

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_fin = str_replace('/', '-', $fecha_fin);

        $inicial = (new Date("{$fecha_inicio}"))->format('Y-m-d');
        $final = (new Date("{$fecha_fin}"))->format('Y-m-d');


        if ($reglas['primerWhere']) {
            $reglas['where'] = " WHERE {$filtro->campo_filtro_where} BETWEEN '{$inicial}' AND '{$final}'";
            $reglas['primerWhere'] = false;
        } else {
            $reglas['where'] .= " AND {$filtro->campo_filtro_where} BETWEEN '{$inicial}' AND '{$final}'";
        }
        return $reglas;
    }

    /**
     * [inputRangoNumeros description]
     * @param  [type] $reqFiltro [description]
     * @param  [type] $filtro    [description]
     * @param  [type] $reglas    [description]
     * @return [type]            [description]
     */
    public function inputRangoNumeros($reqFiltro, $filtro, $reglas)
    {
        $inicial = $reqFiltro[$filtro->id]['inicial'];
        $final = $reqFiltro[$filtro->id]['final'];
        if(!empty($inicial) && !empty($final)){
            if ($reglas['primerWhere']) {
                $reglas['where'] = " WHERE {$filtro->campo_filtro_where} BETWEEN '{$inicial}' AND '{$final}'";
                $reglas['primerWhere'] = false;
            } else {
                $reglas['where'] .= " AND {$filtro->campo_filtro_where} BETWEEN '{$inicial}' AND '{$final}'";
            }
        }
        return $reglas;
    }

    /**
     * [inputText description]
     * @param $reqFiltro
     * @param $filtro
     * @param $reglas
     * @return mixed [type]            [description]
     */
    public function inputText($reqFiltro, $filtro, $reglas)
    {
        if ($reglas['primerWhere'])
        {
            $reglas['where'] = " WHERE {$filtro->campo_filtro_where} LIKE '%{$reqFiltro[$filtro->id]}%'";
            $reglas['primerWhere'] = false;
        } else
        {
            $reglas['where'] .= " AND {$filtro->campo_filtro_where} LIKE '%{$reqFiltro[$filtro->id]}%'";
        }
        return $reglas;
    }

    /**
     * [inputText description]
     * @param $reqFiltro
     * @param $filtro
     * @param $reglas
     * @return mixed [type]            [description]
     */
    public function inputTextExacto($reqFiltro, $filtro, $reglas)
    {
        if ($reglas['primerWhere']) {
            $reglas['where'] = " WHERE UPPER({$filtro->campo_filtro_where}) LIKE '{$reqFiltro[$filtro->id]}'";
            $reglas['primerWhere'] = false;
        } else {
            $reglas['where'] .= " AND UPPER({$filtro->campo_filtro_where}) LIKE '{$reqFiltro[$filtro->id]}'";
        }
        return $reglas;
    }
}
