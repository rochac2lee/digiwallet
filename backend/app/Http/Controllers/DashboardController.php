<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Conta;
use App\Models\Fluxo;
use App\Models\Recorrencia;
use App\Models\Usuario;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalClientes = Cliente::all()->count();
        $totalUsuarios = Usuario::all()->count();

        $saldos = saldos();
        $totalEntradas = $saldos['entradas'];
        $totalSaidas = $saldos['saidas'];

        // Lucro Líquido últimos 6 meses
        $periodoIni = date("Y-m", strtotime(date("Y-m-d") . "-5 month")) . "-01";
        $periodoFim = date("Y-m") . "-01";

        $firstDate  = new DateTime($periodoIni);
        $secondDate = new DateTime($periodoFim);
        $interval   = $firstDate->diff($secondDate);
        $interval->m = $interval->m + 1;

        $dates = DateRecurrences($periodoIni, $interval->m);

        $saldos = [];
        foreach ($dates as $key => $date) {
            $saldos[$key] = saldos($date, date("Y-m-t", strtotime($date)));
        }

        $clienteHabilitado = Config::where('habilitar_clientes', false)->first();

        if ($clienteHabilitado) {
            $dashboard = array(
                [
                    "title" => "Usuários",
                    "total" => $totalUsuarios
                ],
                [
                    "title" => "Entradas",
                    "total" => "R$ " . $totalEntradas
                ],
                [
                    "title" => "Saídas",
                    "total" => "R$ " . $totalSaidas
                ]
            );
        } else {
            $dashboard = array(
                [
                    "title" => "Usuários",
                    "total" => $totalUsuarios
                ],
                [
                    "title" => "Clientes",
                    "total" => $totalClientes
                ],
                [
                    "title" => "Entradas",
                    "total" => "R$ " . $totalEntradas
                ],
                [
                    "title" => "Saídas",
                    "total" => "R$ " . $totalSaidas
                ]
            );
        }

        $entradas = Fluxo::all()->where('tipo_fluxo', 'entrada')->take(5);
        $saidas = Fluxo::all()->where('tipo_fluxo', 'saida')->take(5);


        return response(['status' => "success", 'indicadoresGerais' => $dashboard, 'lucroLiquidoUltimos6Meses' => $saldos, 'entradas' => $entradas, 'saidas' => $saidas], 200);
    }
}
