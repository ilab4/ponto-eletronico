<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;
use App\Ponto;
use App\PontoRazao;

class AcompanhamentoController extends PontoEletronicoController {
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware');
        
    }
    
    public function index(){
        
        $admin = Session::get('login.ponto.painel.admin');
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        $data = array();
        
        if($_POST):
            
            $data_inicio = Request::input('data_inicio');
            $data_inicio_arr = explode("/", $data_inicio);
            $data_inicio_db = $data_inicio_arr[2].'-'.$data_inicio_arr[1].'-'.$data_inicio_arr[0];
            
            $data_fim = Request::input('data_fim');
            $data_fim_arr = explode("/", $data_fim);
            $data_fim_db = $data_fim_arr[2].'-'.$data_fim_arr[1].'-'.$data_fim_arr[0];

            if($admin == 1):
                
                $usuario_selecionado = Request::input('usuario');
                
                if($usuario_selecionado == 'all'):
                    $registros = Ponto::where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
                else:    
                    $registros = Ponto::where(['usuario_id' => $usuario_selecionado])->where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
                endif;
                
                $usuario = array();
                $usuarios = Usuario::orderBy('nome', 'ASC')->get();
            else:
                $registros = Ponto::where(['usuario_id' => $usuario_id])->where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
                $usuario = Usuario::find($usuario_id);
                $usuarios = array();
            endif;
            
        else:
            
            $data_inicio_db = Date('Y') . '-' . Date('m') . '-' . '01';
            $data_fim_db = Date("Y-m-d");
            
            $data_inicio = '01/'. Date('m') . '/' . Date('Y');
            $data_fim = Date("d/m/Y");
            
            if($admin == 1):
                $registros = array();
                $usuario = array();
                $usuarios = Usuario::orderBy('nome', 'ASC')->get();
            else:
                $registros = Ponto::where(['usuario_id' => $usuario_id])->where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
                $usuario = Usuario::find($usuario_id);
                $usuarios = array();
            endif;
            
        endif;
        
        
        foreach($registros as $registro):
            
            $data[$registro->usuario->nome][] = $registro;
        
        endforeach;
        
        
//        die("<PRE>" . print_r($data,1));
        
        $justificativas = PontoRazao::where(['ativo' => 1])->orderBy("descricao", "ASC")->get();
        
        if($admin == 1):
            return view('pontoeletronico/acompanhamento/index-admin')->with('usuario', $usuario)->with('registros', $registros)->with('usuarios', $usuarios)->with('data_inicio', $data_inicio)->with('data_fim', $data_fim)->with('justificativas', $justificativas)->with('data', $data);
        else:    
            return view('pontoeletronico/acompanhamento/index')->with('usuario', $usuario)->with('registros', $registros)->with('usuarios', $usuarios)->with('data_inicio', $data_inicio)->with('data_fim', $data_fim)->with('justificativas', $justificativas)->with('data', $data);
        endif;
        
            
    }
    
    public function index_download($usuario, $inicio, $fim){
        
        $usuario_admin = Session::get('login.ponto.painel.admin');
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        if($usuario_admin != 1):
            $msg = "Download não permitido.";
            Session::put('status.msg', $msg);
            return redirect(getenv('APP_URL').'/painel/acompanhamento');
            die();
        endif;
        
        
        $data = array();
        
        $data_inicio_db = $inicio;
        $data_inicio = $inicio;
        $data_fim_db = $fim;
        $data_fim = $fim;

        
        if($usuario == 'all'):
            $registros = Ponto::where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
        else:  
            
            $usuario_selecionado = Usuario::where(['nome' => $usuario])->first();
        
            $registros = Ponto::where(['usuario_id' => $usuario_selecionado->id])->where('data', '>=', $data_inicio_db)->where('data', '<=', $data_fim_db)->with('usuario')->orderBy('data', 'ASC')->orderBy('entrada', 'ASC')->get();
        endif;

        foreach($registros as $registro):
            $data[$registro->usuario->nome][] = $registro;
        endforeach;       

        return view('pontoeletronico/acompanhamento/index-download')->with('data_inicio', $data_inicio)->with('data_fim', $data_fim)->with('data', $data);

            
    }
    
}