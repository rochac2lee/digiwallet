<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $usuario = DB::table('usuarios')
            ->select('*')
            ->where('usuario', $request->usuario)
            ->where('senha', md5($request->senha))
            ->first();

        if (!$usuario) {
            return response(['status' => "error", 'message' => "Dados de login inválido!"], 404);
        } else {

            $cliente = Cliente::find($usuario->cliente_id);

            $dados = new \stdClass();
            $dados->id = $usuario->id;
            $dados->nome = $usuario->nome;
            $dados->usuario = $usuario->usuario;
            $dados->perfil = $usuario->perfil;

            if ($cliente) {
                $dados->cliente = $cliente;
            }
            return response(['status' => "success", 'token' => $usuario->token, 'usuario' => $dados, 'message' => ""], 200);
        }
    }
}
