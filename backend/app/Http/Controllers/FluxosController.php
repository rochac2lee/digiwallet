<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Conta;
use App\Models\Fluxo;
use App\Models\Recorrencia;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FluxosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fluxos = Fluxo::all();

        foreach ($fluxos as $fluxo) {
            if ($fluxo->conta_id) {
                $fluxo->conta = Conta::find($fluxo->conta_id)->nome;
            }

            $fluxo->recorrencias = DB::table('recorrencias')
                ->select('*')
                ->where('fluxo_id', $fluxo->id)
                ->get();
        }

        return response(['status' => 'success', 'total' => sizeof($fluxos), 'data' => $fluxos], 200);
    }

    /**
     * Cria a recorrencia
     */
    public function newRecorrencia($fluxo, $parcela_numero, $data_referencia)
    {
        $recorrencia = Recorrencia::create([
            "fluxo_id" => $fluxo->id,
            "valor" => $fluxo->valor,
            "status" => false,
            "parcela_numero" => $parcela_numero + 1,
            "data_referencia" => $data_referencia
        ]);

        return $recorrencia;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->conta_id && !Conta::find($request->conta_id)) {
            return response(['status' => "error", 'message' => "Conta não encontrada!"], 404);
        } else if ($request->categoria_id && !Categoria::find($request->categoria_id)) {
            return response(['status' => "error", 'message' => "Categoria não encontrada!"], 404);
        } else {


            $request = $request->all();
            $request['valor'] = str_replace(".", ",", $request['valor']);
            $fluxo = Fluxo::create($request);

            $recorrencias = array();

            $firstDate  = new DateTime($fluxo->data_inicio);
            $secondDate = new DateTime($fluxo->data_fim);
            $interval   = $firstDate->diff($secondDate);
            $interval->m = $interval->m + 1;
            // die();

            if ($fluxo->recorrencia == true) {

                $datas = DateRecurrences($fluxo->data_inicio, $interval->m);

                for ($i = 0; $i < $interval->m; $i++) {
                    $recorrencias[$i] = $this->newRecorrencia($fluxo, $i, $datas[$i]);
                }

            }

            $fluxo->recorrencias = $recorrencias;

            return response(['status' => "success", 'data' => $fluxo, 'message' => "Dados cadastrados com sucesso!"], 201);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fluxo = Fluxo::find($id);

        if (!$fluxo) {
            return response(['status' => "error", 'data' => '', 'message' => "Dados não encontrados!"], 404);
        } else {

            $recorrencias = DB::table('recorrencias')
                ->select('*')
                ->where('fluxo_id', $fluxo->id)
                ->get();

            for ($i = 0; $i < sizeof($recorrencias); $i++) {
                Recorrencia::find($recorrencias[$i]->id)->delete();
            }

            $fluxo->delete();

            return response(['status' => "success", 'message' => "Dados excluídos com sucesso!"], 200);
        }
    }
}
