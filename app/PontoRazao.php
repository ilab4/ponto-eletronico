<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoRazao extends Model
{
    protected $table = 'ponto_razao';
    public $timestamps = false;
    
    public function pontoRazao(){
    	return $this->hasMany('App\PontoAjuste');
    }
    
    public $incrementing = true;
    
    protected $fillable = ['id', 'descricao', 'ativo'];
}
