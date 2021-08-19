<?php namespace App\Http\Controllers\PontoEletronico;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\PontoAjuste;


abstract class PontoEletronicoController extends Controller
{
  
    public function upload($local, $arquivo){
        
        //UPLOAD DO ARQUIVO
        $_UP['pasta'] = $local;
        $_UP['tamanho'] = 1024 * 1024 * 5; // 10Mb
        $_UP['extensoes'] = array('jpg', 'png', 'pdf');
        
        
        $arquivo_nome = $arquivo['name'];
        $arquivo_nome_array = explode(".", $arquivo_nome);
        $extensao = strtolower($arquivo_nome_array[1]);
        
        if (!in_array($extensao, $_UP['extensoes'])) {
            echo "O tipo de arquivo enviado (" . $extensao . ") não é permitido.";
            exit;
        }
        
        $nome_final = md5(uniqid(time())).'.'.$extensao;
        
        if(move_uploaded_file($arquivo['tmp_name'], $local . $nome_final)){
        
            return $nome_final;
            
        } else {
            
            return false;
            
        }
        
    }
    
       
    
}