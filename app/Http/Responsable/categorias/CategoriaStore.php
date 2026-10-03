<?php

namespace App\Http\Responsable\categorias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class CategoriaStore implements Responsable
{
    use MetodosTrait;

    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

     /* Helper privado para obtener las cabeceras estándar con JWT */
     private function getHeaders()
     {
         return [
             'Authorization' => 'Bearer ' . session('api_jwt_token'),
             'Accept'        => 'application/json',
         ];
     }

    public function toResponse($request)
    {
        $categoria = request('categoria', null);
        
        $consultaCategoria = $this->consultaCategoria($this->quitarCaracteresEspeciales(ucwords($categoria)));
        
        if(isset($consultaCategoria) && !empty($consultaCategoria) && !is_null($consultaCategoria))
        {
            if ($request->ajax())
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Esta categoría ya existe.'
                ]);
            }
            alert()->info('Error', 'Esta categoría ya existe.');
            return back();
        } else
        {
            try
            {
                // Pasamos el id_estado de las nuevas categorías por default en 1 "activo"
                $peticionCategoriaStore = $this->clientApi->post('categoria_store', [
                    'headers' => $this->getHeaders(),
                    'json' => [
                        'categoria' => $this->quitarCaracteresEspeciales(ucwords($categoria)),
                        'id_estado' => 1,
                        'id_audit' => session('id_usuario'),
                        'empresa_actual' => session('empresa_actual.id_empresa')
                    ]
                ]);
                $respuestaCategoriaStore = json_decode($peticionCategoriaStore->getBody()->getContents());
    
                if(isset($respuestaCategoriaStore) && !empty($respuestaCategoriaStore))
                {
                    if ($request->ajax())
                    {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Categoría creada satisfactoriamente',
                            'categoria' => $respuestaCategoriaStore
                        ]);
                    }
                    alert()->success('Proceso Exitoso', 'Categoría creada satisfactoriamente');
                    return redirect()->to(route('categorias.index'));
                }
            } catch (Exception $e)
            {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error creando categoria: ' . $e->getMessage()
                    ], 500);
                }
                alert()->error('Error', 'Error creando categoria, si el problema persiste, contacte a Soporte.' . $e->getMessage());
                return back();
            }
        } // FIN else
    }

    // ===================================================================

    public function consultaCategoria($categoria)
    {
        try
        {
            $peticionConsultaCategoria = $this->clientApi->post('consulta_categoria', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'categoria' => $categoria,
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            return json_decode($peticionConsultaCategoria->getBody()->getContents());
        } catch (Exception $e)
        {
            alert()->error('Error', 'Error Exception, inténtelo de nuevo, si el problema persiste, contacte a Soporte.'.$e->getMessage());
            return back();
        }
    }
}
