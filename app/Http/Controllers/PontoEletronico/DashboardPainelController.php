<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;


class DashboardPainelController extends PontoEletronicoController {
    
    public function __construct()
    {
        $this->middleware('authPainelMiddleware');
        
    }
    
    public function index(){
        
        return view('pontoeletronico/dashboard/dashboard-painel');
        
            
    }
    
}