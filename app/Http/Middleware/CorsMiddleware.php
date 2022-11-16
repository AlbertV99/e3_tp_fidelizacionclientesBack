<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        // Pre-Middleware Action
        try {
            return $next($request)
            ->header('Access-Control-Allow-Origin', '*');

        } catch (\Exception $e) {
            return response(["cod"=>"999","Error en la peticion, no se puede procesar"],505);
        }catch(\HttpException $e){
            return response(["cod"=>"999","Error en la peticion, no se puede procesar"],505);
        }

    }
}
