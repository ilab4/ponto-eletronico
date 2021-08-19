<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;


class IndexPainelController extends PontoEletronicoController {
    
    public function index(){
        
        return view('pontoeletronico/index-painel');
            
    }
    
}