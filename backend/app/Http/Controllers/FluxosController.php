<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Conta;
use App\Models\Fluxo;
use App\Models\Recorrencia;
use Carbon\Carbon;
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
        $fluxos = Fluxo::whereMonth('data_inicio', '=', date('m'))->orderBy('created_at', 'desc')->get();
        // $fluxos = Fluxo::orderBy('created_at', 'desc')->get();

        foreach ($fluxos as $fluxo) {
            if ($fluxo->conta_id) {
                $fluxo->conta = Conta::find($fluxo->conta_id)->nome;
            }

            if ($fluxo->cliente_id) {
                $fluxo->cliente = Cliente::find($fluxo->cliente_id)->nome;
                if (strlen($fluxo->cliente) > 15)
                    $fluxo->cliente = substr($fluxo->cliente, 0, 12) . '...';
            } else {
                $fluxo->cliente = "N/A";
            }

            $fluxo->data_inicio_formatada = date('d/m/Y', strtotime($fluxo->data_inicio));

            $fluxo->recorrencias = DB::table('recorrencias')
                ->select('*')
                ->where('fluxo_id', $fluxo->id)
                ->get();

            foreach ($fluxo->recorrencias as $recorrencia) {
                $recorrencia->data_referencia_formatada = date('d/m/Y', strtotime($recorrencia->data_referencia));
            }
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

            $firstDate = new DateTime($fluxo->data_inicio);
            $secondDate = new DateTime($fluxo->data_fim);
            $interval = $firstDate->diff($secondDate);

            $totalMonths = $interval->y * 12 + $interval->m;
            $interval->m = $totalMonths + 1;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {

        if (isset($request->periodo_formatado)) {
            unset($request->periodo_formatado);
        }

        $fluxos = Fluxo::select('*');

        if ($request->periodo) {
            if (sizeof($request->periodo) == 1) {
                $start = Carbon::parse($request->periodo[0])->startOfDay();
                $end = Carbon::parse($request->periodo[0])->endOfDay();
                $fluxos->whereBetween('data_inicio', [$start, $end]);
            } else {
                $start = Carbon::parse($request->periodo[0])->startOfDay();
                $end = Carbon::parse($request->periodo[1])->endOfDay();
                $fluxos->whereBetween('data_inicio', [$start, $end]);
            }
        }
        if ($request->titulo) {
            $fluxos->where('titulo', 'LIKE', '%' . $request->titulo . '%');
        }
        if ($request->status) {
            $fluxos->whereIn('status', $request->status);
        }
        if ($request->tipo_fluxo) {
            $fluxos->whereIn('tipo_fluxo', $request->tipo_fluxo);
        }
        if ($request->forma_pagamento) {
            $fluxos->whereIn('recorrencia', $request->forma_pagamento);
        }

        $fluxos = $fluxos->orderBy('created_at', 'desc')->get();

        foreach ($fluxos as $fluxo) {
            if ($fluxo->conta_id) {
                $fluxo->conta = Conta::find($fluxo->conta_id)->nome;
            }

            if ($fluxo->cliente_id) {
                $fluxo->cliente = Cliente::find($fluxo->cliente_id)->nome;
                if (strlen($fluxo->cliente) > 15)
                    $fluxo->cliente = substr($fluxo->cliente, 0, 12) . '...';
            } else {
                $fluxo->cliente = "N/A";
            }

            $fluxo->data_inicio_formatada = date('d/m/Y', strtotime($fluxo->data_inicio));

            $fluxo->recorrencias = DB::table('recorrencias')
                ->select('*')
                ->where('fluxo_id', $fluxo->id)
                ->get();

            foreach ($fluxo->recorrencias as $recorrencia) {
                $recorrencia->data_referencia_formatada = date('d/m/Y', strtotime($recorrencia->data_referencia));
            }
        }

        return response(['status' => 'success', 'total' => sizeof($fluxos), 'data' => $fluxos], 200);
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
        $fluxo = Fluxo::find($id);

        Recorrencia::where('fluxo_id', $fluxo->id)->delete();

        $request = $request->all();
        unset($request['data_inicio_formatada']);
        unset($request['conta']);
        unset($request['cliente']);
        unset($request['recorrencias']);
        $request['valor'] = str_replace(".", ",", $request['valor']);

        $recorrencias = array();

        $firstDate = new DateTime($fluxo->data_inicio);
        $secondDate = new DateTime($fluxo->data_fim);
        $interval = $firstDate->diff($secondDate);

        $totalMonths = $interval->y * 12 + $interval->m;
        $interval->m = $totalMonths + 1;

        $fluxo->valor = $request['valor'];

        if ($fluxo->recorrencia == true) {

            $request['status'] = $fluxo->status;

            $datas = DateRecurrences($fluxo->data_inicio, $interval->m);

            for ($i = 0; $i < $interval->m; $i++) {
                $recorrencias[$i] = $this->newRecorrencia($fluxo, $i, $datas[$i]);
            }
        } else {
            $request['data_fim'] = null;
        }

        // Atualiza o Fluxo com novos valores
        $fluxo->update($request);

        $fluxo->recorrencias = Recorrencia::where('fluxo_id', $fluxo->id)->get();

        return response(['status' => "success", 'data' => $fluxo, 'message' => "Dados atualizados com sucesso!"], 201);
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