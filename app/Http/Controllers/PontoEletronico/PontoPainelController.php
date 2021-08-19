<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;
use App\Ponto;
use App\PontoAjuste;


class PontoPainelController extends PontoEletronicoController {
    
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware');
        
    }
    
    public function ajuste(){
        
        $url_base = getenv('APP_URL');
        
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        $ponto_id = Request::input('ponto_id');
        $tipo = Request::input('tipo');
        $data = Request::input('data');
        $hora = Request::input('hora');
        $hora_entrada = Request::input('hora_entrada');
        $hora_saida = Request::input('hora_saida');
        $justificativa = Request::input('justificativa');
        $anexo = Request::input('anexo');
        
        $data_arr = explode("/",$data);
        $data = $data_arr[2].'-'.$data_arr[1].'-'.$data_arr[0];
        
        
        $arquivo_anexo = $_FILES["anexo"];
        $varArquivo_anexo = $arquivo_anexo["name"];
        if($varArquivo_anexo != ''):
            $arquivo_nome_final_anexo = $this->upload('../public/upload/razao/', $_FILES['anexo']);
        endif;

               
        if($tipo == 'entrada' OR $tipo == 'saida'):
        
            $ajuste = new PontoAjuste();
            $ajuste->ponto_id = $ponto_id;
            $ajuste->usuario_id = $usuario_id;
            $ajuste->ponto_ajuste_id = 0;
            $ajuste->tipo = $tipo;
            $ajuste->data = $data;
            $ajuste->hora = $hora;
            $ajuste->ponto_razao_id = $justificativa;
            $ajuste->status = 0;
            if($varArquivo_anexo != ''):
                $ajuste->anexo = $arquivo_nome_final_anexo;
            endif;

            $ajuste->save();
            
            
            if($tipo == 'entrada'):
                $ponto = Ponto::find($ponto_id);
                $ponto->entrada = $hora;
                $ponto->entrada_status = 1;
                $ponto->save();
            endif;
            
            if($tipo == 'saida'):
                $ponto = Ponto::find($ponto_id);
                $ponto->saida = $hora;
                $ponto->saida_status = 1;
                $ponto->save();
            endif;
            
        endif;
        
        
        $msg = "Registro salvo com sucesso!";
        Session::put('status.msg', $msg);
            
        return redirect(getenv('APP_URL').'/painel/ajuste');
        
        
    }   
    
    
    
}