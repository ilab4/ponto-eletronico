<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;


class UsuarioController extends PontoEletronicoController {
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware');
        
    }
    
    public function index(){
        
        $usuarios = Usuario::orderBy('nome', 'ASC')->get();
        return view('pontoeletronico/usuario/index')->with('usuarios', $usuarios);
            
    }
    
    
    public function novo(){
        
        return view('pontoeletronico/usuario/data');
            
    }
    
    public function editar($id){
        
        $usuario = Usuario::find($id);
        return view('pontoeletronico/usuario/data')->with('u', $usuario);
            
    } 
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $usuario = Usuario::find(Request::input('id'));
        } else {
            $usuario = new Usuario(); 
        }
        
        $senha = Request::input('senha');
        if(!empty($senha)):
            $usuario->senha = hash('sha1', $senha);
        endif;
        
        $cpf_banco = Request::input('cpf_banco');
        $email_banco = Request::input('email_banco');
        
        $email = Request::input('email');
        $cpf = Request::input('cpf');
        
        $cpf_banco = str_replace(".", "", $cpf_banco);
        $cpf_banco = str_replace("-", "", $cpf_banco);
        
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        
        if(NULL !== Request::input('ativo')):
            $ativo = 1;
        else:
            $ativo = 0;
        endif;
        
        if($email_banco != $email):
            if($this->_verifica_email($email)):
                Session::put('status.msg', 'Esse email já está existe em nosso cadastro!');
                return redirect(getenv('APP_URL').'/painel/usuarios');
                die();
            endif;
        endif;
        
        if($cpf_banco != $cpf):
            if($this->_verifica_cpf($cpf)):
                Session::put('status.msg', 'Esse CPF já está existe em nosso cadastro!');
                return redirect(getenv('APP_URL').'/painel/usuarios');
                die();
            endif;
        endif;
      
        $usuario->nome = Request::input('nome');
        $usuario->email = Request::input('email');
        $usuario->cpf = $cpf;
        $usuario->cargo = Request::input('cargo');
        $usuario->local = Request::input('local');
        $usuario->ativo = $ativo;

        $error = 1;
        if($usuario->save()){
            
            Session::put('status.msg', 'Colaborador salvo com sucesso!');
            return redirect(getenv('APP_URL').'/painel/usuarios');
            
        } else {
            
            return view('pontoeletronico/usuario/data');
            
        }
        
    }    

    public function _verifica_email($email){
        
        $usuario = Usuario::where(['email' => $email])->get();
        
        if(count($usuario)){
            return true;
        } else {
            return false;
        }
            
    }
    
    public function _verifica_cpf($cpf){
        
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $cpf = str_replace("/", "", $cpf);
        
        $usuario = Usuario::where(['cpf' => $cpf])->get();
        
        if(count($usuario)){
            return true;
        } else {
            return false;
        }
            
    }
    
    public function desabilitar($id){
        
        $usuario = Usuario::find($id);
        $usuario->ativo = 0;
        $usuario->save();

        $msg = "Usuário desabilitado com sucesso!";
        Session::put('status.msg', $msg);
        
        return redirect(getenv('APP_URL').'/painel/usuarios');
            
    }
    
    public function habilitar($id){
        
        $usuario = Usuario::find($id);
        $usuario->ativo = 1;
        $usuario->save();

        $msg = "Usuário ativado com sucesso!";
        Session::put('status.msg', $msg);
        
        return redirect(getenv('APP_URL').'/painel/usuarios');
            
    }
    
}