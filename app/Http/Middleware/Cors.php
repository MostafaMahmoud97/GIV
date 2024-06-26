<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $http_origin = $_SERVER['HTTP_ORIGIN'];
        }catch (\Exception $e){
            $http_origin = "http://localhost:5173";
        }


        return $next($request)
            ->header("Access-Control-Allow-Origin",$http_origin)
            ->header("Access-Control-Allow-Credentials","true")
            ->header("Access-Control-Allow-Methods","PUT,POST,GET,DELETE,PATCH,OPTIONS")
            ->header("Access-Control-Allow-Headers","Accept,Authorization,Content-Type,X-App-Locale");
    }
}
