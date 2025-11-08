<?php

namespace App\Http\Responsable\categorias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class CategoriaEdit implements Responsable
{
    protected $idCategoria;

    public function __construct($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'categoria_edit/'.$this->idCategoria, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $categoriaEdit = json_decode($peticion->getBody()->getContents());

            // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'editar'); // valor por defecto

            return match ($tipoModal) {
                'estado' => view('categorias.modal_estado_categoria', compact('categoriaEdit')),
                default  => view('categorias.modal_editar_categoria', compact('categoriaEdit')),
            };
            
        } catch (Exception $e) {
            alert()->error('Error consultando la categoría, contacte a Soporte.');
            return back();
        }
    }
}
