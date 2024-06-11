<?php

use App\Models\Conta;
use Illuminate\Support\Facades\DB;

function base64url_encode($data)
{
    // First of all you should encode $data to Base64 string
    $b64 = base64_encode($data);

    // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
    if ($b64 === false) {
        return false;
    }

    // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
    $url = strtr($b64, '+/', '-_');

    // Remove padding character from the end of line and return the Base64URL result
    return rtrim($url, '=');
}

function MakeJwt($request)
{
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];
    $header = json_encode($header);
    $header = base64_encode($header);

    $payload = $request;
    $payload = json_encode($payload);
    $payload = base64_encode($payload);

    $signature = hash_hmac('sha256', "$header.$payload", '3nc0d3d1g1w4ll3t', true);
    $signature = base64url_encode($signature);

    $jwt_token = "$header.$payload.$signature";

    return $jwt_token;
}

function DateRecurrences(String $date, Int $qtd)
{
    $initial = 0;

    $date = strtotime($date);

    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);

    for ($i = $initial; $i < $qtd; $i++) {

        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            if ($day == 31) {
                $date = "$year-$month-31";
            } else {
                $date = "$year-$month-$day";
            }
        } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            if ($day > 30) {
                $date = "$year-$month-30";
            } else {
                $date = "$year-$month-$day";
            }
        } else if ($month == 2) {
            if ($day > 29) {
                $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
                if ($leap) {
                    $date = "$year-$month-29";
                } else {
                    $date = "$year-$month-28";
                }
            } else {
                if ($day > 28) {
                    $date = "$year-$month-28";
                } else {
                    $date = "$year-$month-$day";
                }
            }
        }

        if ($month == 12) {
            $month = 0;
            $year++;
        }

        $month++;

        $dates[$i] = $date;
    }

    return $dates;
}

function except($request)
{
    if (!empty($request->query()['except']) && $request->query()['except'] == 'true') {
        //exec();
    }
}

function jwt_decode($token)
{
    $tokenParts = explode(".", $token);
    $tokenHeader = base64_decode($tokenParts[0]);
    $tokenPayload = base64_decode($tokenParts[1]);
    $jwtHeader = json_decode($tokenHeader);
    $jwtPayload = json_decode($tokenPayload);
    return $jwtPayload;
}

function saldos($periodoIni = null, $periodoFim = null)
{
    $contas = Conta::all();
    $totalEntradas = 0;
    $totalSaidas = 0;
    $total = 0;

    foreach ($contas as $conta) {
        // echo $periodoIni." - ".$periodoFim."\n";

        if ($periodoIni != null && $periodoFim != null) {
            $entradasAvulsas = DB::table('fluxos')
                ->select('valor')
                ->whereBetween('data_inicio', [$periodoIni, $periodoFim])
                ->where('conta_id', $conta->id)
                ->where('tipo_fluxo', 'entrada')
                ->where('recorrencia', false)
                ->where('status', 2)
                ->get();
        } else {
            $entradasAvulsas = DB::table('fluxos')
                ->select('valor')
                ->where('conta_id', $conta->id)
                ->where('tipo_fluxo', 'entrada')
                ->where('recorrencia', false)
                ->where('status', 2)
                ->get();
        }

        if ($entradasAvulsas) {
            foreach ($entradasAvulsas as $entradaAvulsa) {
                $conta->entradasAvulsas += str_replace(",", ".", $entradaAvulsa->valor);
            }
        } else {
            $conta->entradasAvulsas = null;
        }

        if ($periodoIni != null && $periodoFim != null) {
            $entradas = DB::table('fluxos')
                ->select('recorrencias.valor')
                ->whereBetween('recorrencias.data_referencia', [$periodoIni, $periodoFim])
                ->join('recorrencias', 'recorrencias.fluxo_id', 'fluxos.id')
                ->where('conta_id', $conta->id)
                ->where('fluxos.tipo_fluxo', 'entrada')
                ->where('recorrencias.status', true)
                ->get();
        } else {
            $entradas = DB::table('fluxos')
                ->select('recorrencias.valor')
                ->join('recorrencias', 'recorrencias.fluxo_id', 'fluxos.id')
                ->where('conta_id', $conta->id)
                ->where('fluxos.tipo_fluxo', 'entrada')
                ->where('recorrencias.status', true)
                ->get();
        }

        if ($entradas) {
            foreach ($entradas as $entrada) {
                $conta->entradas += str_replace(",", ".", $entrada->valor);
            }
        } else {
            $conta->entradas = null;
        }

        if ($periodoIni != null && $periodoFim != null) {
            $saidasAvulsas = DB::table('fluxos')
                ->select('valor')
                ->whereBetween('data_inicio', [$periodoIni, $periodoFim])
                ->where('conta_id', $conta->id)
                ->where('tipo_fluxo', 'saida')
                ->where('recorrencia', false)
                ->where('status', 2)
                ->get();
        } else {
            $saidasAvulsas = DB::table('fluxos')
                ->select('valor')
                ->where('conta_id', $conta->id)
                ->where('tipo_fluxo', 'saida')
                ->where('recorrencia', false)
                ->where('status', 2)
                ->get();
        }

        if ($saidasAvulsas) {
            foreach ($saidasAvulsas as $saidaAvulsa) {
                $conta->saidasAvulsas += str_replace(",", ".", $saidaAvulsa->valor);
            }
        } else {
            $conta->saidasAvulsas = null;
        }

        if ($periodoIni != null && $periodoFim != null) {
            $saidas = DB::table('fluxos')
                ->select('recorrencias.valor')
                ->whereBetween('recorrencias.data_referencia', [$periodoIni, $periodoFim])
                ->join('recorrencias', 'recorrencias.fluxo_id', 'fluxos.id')
                ->where('conta_id', $conta->id)
                ->where('fluxos.tipo_fluxo', 'saida')
                ->where('recorrencias.status', true)
                ->get();
        } else {
            $saidas = DB::table('fluxos')
                ->select('recorrencias.valor')
                ->join('recorrencias', 'recorrencias.fluxo_id', 'fluxos.id')
                ->where('conta_id', $conta->id)
                ->where('fluxos.tipo_fluxo', 'saida')
                ->where('recorrencias.status', true)
                ->get();
        }

        if ($saidas) {
            foreach ($saidas as $saida) {
                $conta->saidas += str_replace(",", ".", $saida->valor);
            }
        } else {
            $conta->saidas = null;
        }

        $totalEntradas = $totalEntradas + ($conta->entradas + $conta->entradasAvulsas);
        $totalSaidas = $totalSaidas + ($conta->saidas + $conta->saidasAvulsas);
        $total = ($totalEntradas - $totalSaidas);

        return [
            "data" => date("m/y", strtotime($periodoIni)),
            "entradas" => number_format($totalEntradas, 2, ',', ''),
            "saidas" => number_format($totalSaidas, 2, ',', ''),
            // "total" => number_format($total, 2, ',', ''),
            "total" => number_format($total, 2, '.', ''),
        ];
    }
}
