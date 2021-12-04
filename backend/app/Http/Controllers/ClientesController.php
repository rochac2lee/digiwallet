<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Cliente::all();

        return response(['status' => 'success', 'total' => sizeof($cliente), 'data' => $cliente], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request = $request->all();
        $cliente = Cliente::create($request);

        return response(['status' => "success", 'data' => $cliente, 'message' => "Cliente $cliente->nome cadastrado com sucesso!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response(['status' => "error", 'data' => '', 'message' => "Cliente não enconrado!"], 404);
        } else {
            return response(['status' => "success", 'data' => $cliente, 'message' => ""], 200);
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
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response(['status' => "error", 'data' => '', 'message' => "Cliente não enconrado!"], 404);
        } else {

            $request = $request->all();
            $cliente->update($request);

            return response(['status' => "success", 'data' => $cliente, 'message' => "Cliente $cliente->nome atualizado com sucesso!"], 200);
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
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response(['status' => "error", 'data' => '', 'message' => "Cliente não enconrado!"], 404);
        } else {

            $cliente->delete();

            return response(['status' => "success", 'data' => $cliente, 'message' => "Cliente $cliente->nome excluído com sucesso!"], 200);
        }
    }
}
