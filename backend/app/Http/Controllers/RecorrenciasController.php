<?php

namespace App\Http\Controllers;

use App\Models\Fluxo;
use App\Models\Recorrencia;
use Illuminate\Http\Request;

class RecorrenciasController extends Controller
{
    public function index()
    {
        $recorrencias = Recorrencia::all();

        return response(['status' => 'success', 'total' => sizeof($recorrencias), 'data' => $recorrencias], 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recorrencia = Recorrencia::find($id);

        if (!$recorrencia) {
            return response(['status' => "error", 'data' => '', 'message' => "Dados não encontrados!"], 404);
        } else {
            return response(['status' => "success", 'data' => $recorrencia, 'message' => ""], 200);
        }
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recorrencia = Recorrencia::find($id);

        if (!$recorrencia) {
            return response(['status' => "error", 'data' => '', 'message' => "Dados não encontradoss!"], 404);
        } else if ($request->fluxo_id && !Fluxo::find($request->fluxo_id)) {
            return response(['status' => "error", 'message' => "Fluxo não encontrado!"], 404);
        } else {

            $request = $request->all();
            $recorrencia->update($request);

            return response(['status' => "success", 'data' => $recorrencia, 'message' => "Dados atualizados com sucesso!"], 200);
        }
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recorrencia = Recorrencia::find($id);

        if (!$recorrencia) {
            return response(['status' => "error", 'data' => '', 'message' => "Dados não encontradoss!"], 404);
        } else {

            $recorrencia->delete();

            return response(['status' => "success", 'message' => "Dados excluídos com sucesso!"], 200);
        }
    }
}
