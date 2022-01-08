<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = array([
            "categoria" => "Pagamentos",
            "tipo_categoria" => 1
        ], [
            "categoria" => "Rendimentos",
            "tipo_categoria" => 1
        ], [
            "categoria" => "Vendas",
            "tipo_categoria" => 1
        ], [
            "categoria" => "Recebimentos",
            "tipo_categoria" => 1
        ], [
            "categoria" => "Pagamentos",
            "tipo_categoria" => 2
        ], [
            "categoria" => "Serviços",
            "tipo_categoria" => 2
        ], [
            "categoria" => "Carro",
            "tipo_categoria" => 2
        ], [
            "categoria" => "Transporte",
            "tipo_categoria" => 2
        ], [
            "categoria" => "Vestuário",
            "tipo_categoria" => 2
        ], [
            "categoria" => "Aluguel",
            "tipo_categoria" => 2
        ]);

        for ($i = 0; $i < sizeOf($categorias); $i++) {
            DB::table('categorias')->insert($categorias[$i]);
        }
    }
}
