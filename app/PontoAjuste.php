<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoAjuste extends Model
{
    protected $table = 'ponto_ajuste';
    
    protected $casts = [
			'data' => 'date'
	];
    
    public function pontoRazao(){
        return $this->belongsTo('App\PontoRazao', 'ponto_razao_id');
    }
    
    public function usuario(){
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
}
