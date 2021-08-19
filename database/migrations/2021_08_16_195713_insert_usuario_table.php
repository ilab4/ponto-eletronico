<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usuarios = 
        [
          [
            'nome'          => 'ADMNISTRADOR',
            'cpf'          => '57761749370',
            'email'          => 'email@gmail.com',
            'senha'          => '89e495e7941cf9e40e6980d14a16bf023ccd4c91',
            'cargo'          => 'ADM',
            'admin'          => 1,
            'ativo'          => 1,
          ],
          [
            'nome'          => 'FUNCIONARIO 1',
            'cpf'          => '07033337477',
            'email'          => 'email2@gmail.com',
            'senha'          => '89e495e7941cf9e40e6980d14a16bf023ccd4c91',
            'cargo'          => 'AUX ADMINISTRATIVO',
            'admin'          => 0,
            'ativo'          => 1,
          ] 
        ];
        
        foreach ($usuarios as $usuario) {
            \App\Usuario::create($usuario);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
