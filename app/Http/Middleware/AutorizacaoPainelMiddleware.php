<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Session;

class AutorizacaoPainelMiddleware
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
        
        $usuario_logado = Session::get('login.ponto.painel.usuario_id');
        if(!isset($usuario_logado) OR $usuario_logado == ''){
            
            $url_base = getenv('APP_URL').'/painel';
            
            echo("<script>window.location.replace(\"$url_base\");</script>");
            
        }
        
        return $next($request);
    }
}
