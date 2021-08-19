<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;
use App\Ponto;
use App\PontoAjuste;
use App\PontoRazao;


class PontoAjusteController extends PontoEletronicoController {
    
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware');
        
    }
    
    public function index(){
        
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        $usuario_admin = Session::get('login.ponto.painel.admin');
        
        $justificativas = PontoRazao::where(['ativo' => 1])->orderBy("descricao", "ASC")->get();
        
        if($usuario_admin == 1):
            $solicitacoes = PontoAjuste::where(['status' => 0])->with('pontoRazao')->orderBY('created_at', 'ASC')->get();
        
            return view('pontoeletronico/ajuste/index-admin')->with('solicitacoes', $solicitacoes)->with('justificativas', $justificativas);
        else:  
            $solicitacoes = PontoAjuste::where(['usuario_id' => $usuario_id])->with('pontoRazao')->orderBY('created_at', 'ASC')->get();
        
            return view('pontoeletronico/ajuste/index')->with('solicitacoes', $solicitacoes)->with('justificativas', $justificativas);
        endif;
        
        
        
    } 
    
    public function delete($id){
        
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        $solicitacao = PontoAjuste::find($id);
        
        if($solicitacao->usuario_id != $usuario_id):
            $msg = "Exclusão não permitida.";
            Session::put('status.msg', $msg);
            return redirect(getenv('APP_URL').'/painel/ajuste');
            die();
        endif;
        
        
        if($solicitacao->status == 0):
            
            $solicitacao_delete = PontoAjuste::find($id)->delete();
        
            if($solicitacao->ponto_ajuste_id === 0):
                $solicitacao_delete1 = PontoAjuste::where(['ponto_ajuste_id' => $id])->delete();
            else:
                $solicitacao_delete1 = PontoAjuste::find($solicitacao->ponto_ajuste_id)->delete();
            endif;
            
            if($solicitacao->ponto_id != 0):
                
                $ponto_update = Ponto::find($solicitacao->ponto_id);
                
                if($solicitacao->tipo == 'entrada'):
                    $ponto_update->entrada = NULL;
                    $ponto_update->entrada_status = NULL;
                endif;
                
                if($solicitacao->tipo == 'saida'):
                    $ponto_update->saida = NULL;
                    $ponto_update->saida_status = NULL;
                endif;
                
                $ponto_update->save();
                
            endif;
        
            $msg = "Registro excluído com sucesso!";
            Session::put('status.msg', $msg);

            return redirect(getenv('APP_URL').'/painel/ajuste');
        
        else:
            
            $msg = "Somente registros não analisados podem ser excluídos.";
            Session::put('status.msg', $msg);

            return redirect(getenv('APP_URL').'/painel/ajuste');
            
        endif;
        
        
    } 
    
    public function salvar(){
        
        $url_base = getenv('APP_URL');
        
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        $ponto_id = 0;
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

               
        if($tipo == 'periodo'):
            
            $hora_entrada = Request::input('hora_entrada');
            $hora_saida = Request::input('hora_saida');
            
            
            $ajuste0 = new PontoAjuste();
            $ajuste0->ponto_id = $ponto_id;
            $ajuste0->usuario_id = $usuario_id;
            $ajuste0->ponto_ajuste_id = $ponto_id;
            $ajuste0->tipo = 'entrada';
            $ajuste0->data = $data;
            $ajuste0->hora = $hora_entrada;
            $ajuste0->ponto_razao_id = $justificativa;
            $ajuste0->status = 0;
            if($varArquivo_anexo != ''):
                $ajuste0->anexo = $arquivo_nome_final_anexo;
            endif;
            $ajuste0->save();
            
            
            $ajuste = new PontoAjuste();
            $ajuste->ponto_id = $ponto_id;
            $ajuste->usuario_id = $usuario_id;
            $ajuste->ponto_ajuste_id = $ajuste0->id;
            $ajuste->tipo = 'saida';
            $ajuste->data = $data;
            $ajuste->hora = $hora_saida;
            $ajuste->ponto_razao_id = $justificativa;
            $ajuste->status = 0;
            if($varArquivo_anexo != ''):
                $ajuste->anexo = $arquivo_nome_final_anexo;
            endif;
            $ajuste->save();
            
        endif;
        
        $msg = "Registro salvo com sucesso!";
        Session::put('status.msg', $msg);
            
        return redirect(getenv('APP_URL').'/painel/ajuste');
        
        
    }
    
    public function certificar(){
        
        $usuario_admin = Session::get('login.ponto.painel.admin');
        
        if($usuario_admin != 1):
            $msg = "Certificação não permitida.";
            Session::put('status.msg', $msg);
            return redirect(getenv('APP_URL').'/painel/ajuste');
            die();
        endif;
        
        
        $url_base = getenv('APP_URL');
        
        $usuario_id = Session::get('login.ponto.painel.usuario_id');
        
        $solicitacao_id = Request::input('solicitacao_id');
        $botao = Request::input('botao');
        $obs = Request::input('obs');

        
        $pontoajuste = PontoAjuste::find($solicitacao_id);
        
        $colaborador = $pontoajuste->usuario_id;
        $tipo = $pontoajuste->tipo;
        $data = $pontoajuste->data;
        $hora = $pontoajuste->hora;
        $ponto_id = $pontoajuste->ponto_id;
        $ponto_ajuste_id = $pontoajuste->ponto_ajuste_id;
        
        if($ponto_id === '0'):

            if($botao == 'sim'):
            
                if($tipo == 'entrada'):
                    $ponto = new Ponto();
                    $ponto->usuario_id = $colaborador;
                    $ponto->data = $data;
                    $ponto->entrada = $hora;
                    $ponto->entrada_status = 2;
                    $ponto->status = 0;
                    $ponto->save();
                endif;

                if($tipo == 'saida'):
                    $ponto = new Ponto();
                    $ponto->usuario_id = $colaborador;
                    $ponto->data = $data;
                    $ponto->saida = $hora;
                    $ponto->saida_status = 2;
                    $ponto->status = 0;
                    $ponto->save();
                endif;
                
                $novo_ponto_id = $ponto->id;
                
                $pontoajuste->ponto_id = $novo_ponto_id;
                $pontoajuste->status = 1;
                $pontoajuste->obs_supervisor = $obs;
                $pontoajuste->save();
                
                
                if($ponto_ajuste_id === 0):
                    DB::update("UPDATE ponto_ajuste set ponto_id = $novo_ponto_id WHERE ponto_ajuste_id = $solicitacao_id");
                else:
                    DB::update("UPDATE ponto_ajuste set ponto_id = $novo_ponto_id WHERE id = $ponto_ajuste_id");
                endif;

                
            elseif($botao == 'nao'):

                $pontoajuste->status = 2;
                $pontoajuste->obs_supervisor = $obs;
                $pontoajuste->save();

            endif;
        
        else:
            if($botao == 'sim'):
            
                $pontoajuste->status = 1;
                $pontoajuste->obs_supervisor = $obs;
                $pontoajuste->save();
                
                if($tipo == 'entrada'):
                    $ponto = Ponto::find($ponto_id);
                    $ponto->entrada = $hora;
                    $ponto->entrada_status = 2;
                    $ponto->save();
                endif;

                if($tipo == 'saida'):
                    $ponto = Ponto::find($ponto_id);
                    $ponto->saida = $hora;
                    $ponto->saida_status = 2;
                    $ponto->save();
                endif;
                
                
            elseif($botao == 'nao'):
                
                $pontoajuste->status = 2;
                $pontoajuste->obs_supervisor = $obs;
                $pontoajuste->save();
                
                if($tipo == 'entrada'):
                    $ponto = Ponto::find($ponto_id);
                    $ponto->entrada = NULL;
                    $ponto->entrada_status = NULL;
                    $ponto->save();
                endif;

                if($tipo == 'saida'):
                    $ponto = Ponto::find($ponto_id);
                    $ponto->saida = NULL;
                    $ponto->saida_status = NULL;
                    $ponto->save();
                endif;
                
            endif;
            
            
        endif;
        
        
        $msg = "Registro salvo com sucesso!";
        Session::put('status.msg', $msg);
            
        return redirect(getenv('APP_URL').'/painel/ajuste');
        
        
    }
    
}