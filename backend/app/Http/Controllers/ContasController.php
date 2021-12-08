<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContasController extends Controller
{
    public function index()
    {
        $contas = Conta::all();

        return response(['status' => 'success', 'total' => sizeof($contas), 'data' => $contas], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $conta = Conta::create([
            'nome' => $request->nome,
            'saldo' => $request->saldo
        ]);

        $conta = json_decode($conta);

        return response(['status' => "success", 'data' => $conta, 'message' => "Conta $request->nome cadastrada com sucesso!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conta = Conta::find($id);

        if (!$conta) {
            return response(['status' => "error", 'data' => '', 'message' => "Conta não encontrada!"], 404);
        } else {
            return response(['status' => "success", 'data' => $conta, 'message' => ""], 200);
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
        $conta = Conta::find($id);

        if (!$conta) {
            return response(['status' => "error", 'data' => '', 'message' => "Conta não encontrada!"], 404);
        } else {

            $request = $request->all();
            $conta->update($request);

            return response(['status' => "success", 'data' => $conta, 'message' => "Conta atualizada com sucesso!"], 200);
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
        $conta = Conta::find($id);

        if (!$conta) {
            return response(['status' => "error", 'data' => '', 'message' => "Conta não encontrada!"], 404);
        } else {

            $conta->delete();

            return response(['status' => "success", 'message' => "Conta excluída com sucesso!"], 200);
        }
    }
}