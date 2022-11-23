<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\ParameterBag;

class DeviceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /** 
     * Custom parameters. 
     * 
     * @var \Symfony\Component\HttpFoundation\ParameterBag 
     * 
     * @api 
    */

    public $attributes;


    public function handle($request, Closure $next){

        $auth = false;

        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            $jwt = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }else if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            $jwt = $_SERVER['HTTP_AUTHORIZATION'];
        }else{
            $jwt = $request->header('Authorization', null);
        }

        if(!$jwt) {
            return response()->json(['message' => 'Dispositivo no autorizado'], 401);
        }

        try {
            $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET'),'HS256'));
            $auth = true;
        } catch(ExpiredException $e) {
            $auth = true;
        } catch(Exception $e) {
            return response()->json(['message' => 'Dispositivo no autorizado'], 401);
        }

        $request->attributes->add(['auth'=>$auth]);
        return $next($request);
    }
}

//1676295670 //13-02-2023