<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            except($request);

            $token_decoded = json_decode($request->header('Authorization'));

            if (!is_object($token_decoded)) {
                $data = jwt_decode($request->header('Authorization'));

                $request->headers->set('Authorization', $data);
            } else {
                return response()->json(array('status' => "error", 'message' => "Token inválido!"));
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(array('status' => "error", 'message' => "Token inválido!"));
        }
    }
}
