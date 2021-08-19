<?php namespace App\Http\Controllers\PontoEletronico;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Usuario;
use App\Ponto;

class DashboardController extends PontoEletronicoController {
    
    public function __construct()
    {
        $this->middleware('authMiddleware');
        
    }
    
    public function index(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.ponto.usuario_id');
        
        $usuario = Usuario::find($usuario_id);
        
        $registros = Ponto::where(['usuario_id' => $usuario_id, 'data' => $hoje])->orderBy('id', 'ASC')->get();
        
        return view('pontoeletronico/registro/index')->with('usuario', $usuario)->with('registros', $registros);
        
            
    }
    
}