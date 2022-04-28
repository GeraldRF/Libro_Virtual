<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->is("legends/get-upload/*")){
            return $next($request);
        }else {

        return $next($request)
            ->header('Access-Control-Allow-Origin', "*")
            ->header('Access-Control-Allow-Methods', "GET,POST,PATCH,PUT,DELETE, OPTIONS")
            ->header('Access-Control-Allow-Headers', "*");
        }
      
    }
}
