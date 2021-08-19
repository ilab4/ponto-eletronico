<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;

class LoginPainelController extends PontoEletronicoController {
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware', ['except' => ['login']]);
        
    }
    
    public function login(){
        
        $cpf = Request::input('cpf');
        $senha = Request::input('senha');
        
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        
        if(empty($cpf) OR empty($senha)):
            return redirect(getenv('APP_URL').'/painel');
        endif;
        
        $senha = hash('sha1', $senha);
        
        $login = Usuario::where(['cpf' => $cpf, 'senha' => $senha])->first();
        
        
        if(isset($login->id)):

            Session::put('login.ponto.painel.usuario_id', $login->id);
            Session::put('login.ponto.painel.admin', $login->admin);
            Session::put('login.ponto.painel.usuario_nome', $login->nome);
            
            return redirect(getenv('APP_URL').'/painel/dashboard');
            
        else:

            $erro = "Dados inválidos, tente novamente!";
            Session::put('status.msg', $erro);

            return redirect(getenv('APP_URL').'/painel');
            
        endif;
        
            
    }
    
    
    public function sair(){
        
        Session::forget('login.ponto.painel.usuario_id');
        Session::forget('login.ponto.painel.admin');
        Session::forget('login.ponto.painel.usuario_nome');
                      
        return redirect(getenv('APP_URL').'/painel');
            
    } 
    
}