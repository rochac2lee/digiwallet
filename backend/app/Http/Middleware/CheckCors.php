<?php

namespace App\Http\Middleware;

use Closure;

class CheckCors {

    public function handle($request, Closure $next)
    {
    return $next($request)
    //Acrescente as 3 linhas abaixo
    ->header('Access-Control-Allow-Origin', "*")
    ->header('Access-Control-Allow-Methods', "PUT, PATCH, POST, DELETE, GET, OPTIONS")
    ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");
    }
}
