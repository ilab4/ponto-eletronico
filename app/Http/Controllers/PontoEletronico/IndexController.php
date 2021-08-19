<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Http\Request;

class IndexController extends PontoEletronicoController {
    
    public function index(Request $request){
        
        return view('pontoeletronico/index');
            
    }
    
}