<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    
    public function pontoAjuste(){
    	return $this->hasMany('App\PontoAjuste');
    }
    
    public function ponto(){
    	return $this->hasMany('App\Ponto');
    }
    
  
    protected $fillable = ['id', 'nome', 'cpf', 'email', 'senha', 'cargo', 'admin', 'ativo'];
    
}
