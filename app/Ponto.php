<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    protected $table = 'ponto';
    
    public function usuario(){
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
}
