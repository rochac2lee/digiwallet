<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = Config::all();

        return response(['status' => 'success', 'total' => sizeof($configs), 'data' => $configs], 200);
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
        $config = Config::find($id);

        if (!$config) {
            return response(['status' => "error", 'data' => '', 'message' => "Configuração não encontrada!"], 404);
        } else {

            $request = $request->all();
            $config->update($request);

            return response(['status' => "success", 'data' => $config, 'message' => "Configurações atualizadas com sucesso!"], 200);
        }
    }
}
