<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = array([
            "nome" => "Administrador",
            "usuario" => "admin@digiwallet.com",
            "senha" => md5("admin"),
            'token' =>MakeJwt([
                'data' => [
                    'iss' => 'digiwallet',
                    'nome' => "Administrador",
                    'usuario' => "admin@digiwallet.com"
                ]
                ]),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ]);

        DB::table('usuarios')->insert($usuarios);
    }
}
