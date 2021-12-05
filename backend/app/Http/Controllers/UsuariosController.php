<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();

        return response(['status' => 'success', 'total' => sizeof($usuarios), 'data' => $usuarios], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $usuario = DB::table('usuarios')
            ->select('*')
            ->where('usuario', $request->usuario)
            ->first();
            
        if ($usuario) {
            return response(['status' => "error", 'data' => $usuario, 'message' => "Usuário $request->usuario já está cadastrado!"], 409);
        } else if ($request->cliente_id && !Cliente::find($request->cliente_id)) {
            return response(['status' => "error", 'message' => "Cliente não encontrado!"], 404);
        } else {
            $usuario = Usuario::create([
                'nome' => $request->nome,
                'usuario' => $request->usuario,
                'senha' => md5($request->senha),
                'cliente_id' => $request->cliente_id,
                'token' => MakeJwt([
                    'data' => [
                        'iss' => 'digiwallet',
                        'nome' => $request->nome,
                        'usuario' => $request->usuario
                    ]
                ])
            ]);

            $usuario = json_decode($usuario);

            return response(['status' => "success", 'data' => $usuario, 'message' => "Usuário $request->nome cadastrado com sucesso!"], 201);
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
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response(['status' => "error", 'data' => '', 'message' => "Usuário não enconrado!"], 404);
        } else {
            return response(['status' => "success", 'data' => $usuario, 'message' => ""], 200);
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
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response(['status' => "error", 'data' => '', 'message' => "Usuário não enconrado!"], 404);
        } else if ($request->cliente_id && !Cliente::find($request->cliente_id)) {
            return response(['status' => "error", 'message' => "Cliente não encontrado!"], 404);
        } else {

            if (isset($request->senha)) {
                $senha = md5($request->senha);
            } else {
                $senha = $usuario->senha;
            }

            $request = $request->all();
            $request['senha'] = $senha;
            $usuario->update($request);

            return response(['status' => "success", 'data' => $usuario, 'message' => "Usuário $usuario->nome atualizado com sucesso!"], 200);
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
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response(['status' => "error", 'data' => '', 'message' => "Usuário não enconrado!"], 404);
        } else {

            $usuario->delete();

            return response(['status' => "success", 'message' => "Usuário $usuario->nome excluído com sucesso!"], 200);
        }
    }
}
