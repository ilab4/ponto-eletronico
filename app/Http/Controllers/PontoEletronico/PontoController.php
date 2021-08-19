<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;
use App\Ponto;


class PontoController extends PontoEletronicoController {
    
    
    public function __construct()
    {
        $this->middleware('authMiddleware');
        
    }
    
    public function registrar_validando(){
        
        $url_base = getenv('APP_URL');
        
        $usuario_id = Session::get('login.ponto.usuario_id');
        
        $hoje = Date("Y-m-d");
        
        $ultimo_registro = Ponto::where(['usuario_id' => $usuario_id, 'data' => $hoje])->orderBy('id', 'DESC')->first();
        
        if($ultimo_registro):
            $registro_entrada = $ultimo_registro->entrada;
            $registro_saida = $ultimo_registro->saida;
        else:
            $registro_entrada = '';
            $registro_saida = '';
        endif;
        
        
        $area = Request::input('area');
        $hora_registrada = Request::input('hora');
      
        
        if($area == 'entrada'):
            
            if(!empty($registro_saida) AND !empty($registro_entrada)):
                
                $ponto = new Ponto();
                $ponto->usuario_id = $usuario_id;
                $ponto->data = $hoje;
                $ponto->entrada = $hora_registrada;
                $ponto->entrada_status = 0;
                $ponto->status = 0;
                $ponto->save();
                
                Session::put('status.msg', 'Entrada registrada com sucesso! Até breve!');
                Session::put('status.error_redirect', $url_base.'/sair');
                
                return redirect(getenv('APP_URL').'/dashboard');
            
            elseif(!empty($registro_saida) AND empty($registro_entrada)):    
                
                $ponto = new Ponto();
                $ponto->usuario_id = $usuario_id;
                $ponto->data = $hoje;
                $ponto->entrada = $hora_registrada;
                $ponto->entrada_status = 0;
                $ponto->status = 0;
                $ponto->save();
                
                Session::put('status.msg', 'Entrada registrada com sucesso! Até breve!');
                Session::put('status.error_redirect', $url_base.'/sair');
                
                return redirect(getenv('APP_URL').'/dashboard');
                
            elseif(empty($registro_saida) AND !empty($registro_entrada)):
                
                Session::put('status.hora_registrada', $hora_registrada);
                Session::put('status.area', $area);
                
                Session::put('status.msg_confirm', 'Você está fazendo um registro de entrada sem um registro prévio de saída. Confirma?');
                Session::put('status.redir_confirm', $url_base.'/registrar');  
            
            else:
                
                $ponto = new Ponto();
                $ponto->usuario_id = $usuario_id;
                $ponto->data = $hoje;
                $ponto->entrada = $hora_registrada;
                $ponto->entrada_status = 0;
                $ponto->status = 0;
                $ponto->save();
                
                Session::put('status.msg', 'Entrada registrada com sucesso! Até breve!');
                Session::put('status.error_redirect', $url_base.'/sair');
                
                return redirect(getenv('APP_URL').'/dashboard');
                
            endif;
            
        endif;
        
        
        
        if($area == 'saida'):
            
            if(!empty($registro_saida) AND !empty($registro_entrada)):

                Session::put('status.hora_registrada', $hora_registrada);
                Session::put('status.area', $area);
                
                Session::put('status.msg_confirm', 'Você está fazendo um registro de saída sem um registro prévio de entrada. Confirma?');
                Session::put('status.redir_confirm', $url_base.'/registrar');

                return redirect(getenv('APP_URL').'/dashboard');
            
            elseif(!empty($registro_saida) AND empty($registro_entrada)):    
                
                $ponto = new Ponto();
                $ponto->usuario_id = $usuario_id;
                $ponto->data = $hoje;
                $ponto->saida = $hora_registrada;
                $ponto->saida_status = 0;
                $ponto->status = 0;
                $ponto->save();
                
                Session::put('status.msg', 'Saída registrada com sucesso! Até breve!');
                Session::put('status.error_redirect', $url_base.'/sair');
                
                return redirect(getenv('APP_URL').'/dashboard');
                
            elseif(empty($registro_saida) AND !empty($registro_entrada)):
                
                $ponto = Ponto::find($ultimo_registro->id);
                $ponto->saida = $hora_registrada;
                $ponto->saida_status = 0;
                $ponto->save();
                
                Session::put('status.msg', 'Saída registrada com sucesso! Até breve!');
                Session::put('status.error_redirect', $url_base.'/sair');  
                
                return redirect(getenv('APP_URL').'/dashboard');
            
            else:

                Session::put('status.hora_registrada', $hora_registrada);
                Session::put('status.area', $area);
                
                Session::put('status.msg_confirm', 'Você está fazendo um registro de saída sem um registro prévio de entrada. Confirma?');
                Session::put('status.redir_confirm', $url_base.'/registrar');
                
                return redirect(getenv('APP_URL').'/dashboard');
                
            endif;
            
        endif;
        
        
    }
    
    public function registrar(){
        
        $url_base = getenv('APP_URL');
        
        $usuario_id = Session::get('login.ponto.usuario_id');
        
        $hoje = Date("Y-m-d");
        
        $hora_registrada = Session::get('status.hora_registrada');
        $area = Session::get('status.area');

               
        if($area == 'entrada'):
        
            $ponto = new Ponto();
            $ponto->usuario_id = $usuario_id;
            $ponto->data = $hoje;
            $ponto->entrada = $hora_registrada;
            $ponto->entrada_status = 0;
            $ponto->status = 0;
            $ponto->save();

            Session::put('status.msg', 'Entrada registrada com sucesso! Até breve!');
            Session::put('status.error_redirect', $url_base.'/sair');
            
        endif;
        
        if($area == 'saida'):
            
            $ponto = new Ponto();
            $ponto->usuario_id = $usuario_id;
            $ponto->data = $hoje;
            $ponto->saida = $hora_registrada;
            $ponto->saida_status = 0;
            $ponto->status = 0;
            $ponto->save();    
            
            Session::put('status.msg', 'Saída registrada com sucesso! Até breve!');
            Session::put('status.error_redirect', $url_base.'/sair');
            
        endif;
        
        return redirect(getenv('APP_URL').'/dashboard');
        
        
    }
    
}