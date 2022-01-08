<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function getCategorias($tipo_categoria) {
        $categorias = DB::table('categorias')
            ->select('id', 'categoria', 'tipo_categoria')
            ->where('tipo_categoria', $tipo_categoria)
            ->get();

            foreach ($categorias as $categoria) {
                if ($categoria->tipo_categoria == 1) {
                    $categoria->tipo_categoria_nome = "Entradas";
                } else {
                    $categoria->tipo_categoria_nome = "Saídas";
                }
            }

            if (sizeOf($categorias) == 0) {
                return response(['status' => "error", 'message' => "Nenhuma categoria encontrada para o tipo informado!"], 404);
            } else {
                return response(['status' => "success", 'data' => $categorias, 'message' => ""], 200);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response(['status' => "error", 'data' => '', 'message' => "Categoria não encontrada!"], 404);
        } else {
            return response(['status' => "success", 'data' => [$categoria], 'message' => ""], 200);
        }
    }
}
