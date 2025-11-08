<?php

namespace App\Http\Responsable\Informes;

use App\Http\Responsable\Informes\FormatoInformes;
use Illuminate\Contracts\Support\Responsable;
use Exception;

/**
 * Se encarga de la respuesta del informe
 */
class RespuestaInforme implements Responsable
{

    public function toResponse($request)
    {
        try
        {
            $formato = new FormatoInformes();
            //se sacan los datos enviados por la petición

            $datos = $request->all();

            //se le envían los datos para que procesa hacer la tabla
            $respuesta = $formato->carga($datos);

            if ($respuesta['status'])
            {
                $input = $respuesta['input'];
                return response()->json(['status' => true, 'data' => $input], 200);
            }

            if (!$respuesta['status'] && isset($respuesta['msg']) && $respuesta['msg'] != null)
            {
                return response()->json(['status' => false, 'msg' => $respuesta['msg']]);
            }

            return response()->json(['status' => false]);

        } catch (Exception $e)
        {
            logger()->error('Error en RespuestaInforme: ' . $e->getMessage());
        }
    }
}
