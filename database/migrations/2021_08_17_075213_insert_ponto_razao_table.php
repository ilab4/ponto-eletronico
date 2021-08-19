<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPontoRazaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $razoes = 
        [
          [
            'descricao'          => 'Consulta médica',
            'ativo'          => 1,
          ],
          [
            'descricao'          => 'Acompanhamento de parente em consulta médica',
            'ativo'          => 1,
          ],
          [
            'descricao'          => 'Falha na máquina de registro de ponto',
            'ativo'          => 1,
          ], 
          [
            'descricao'          => 'Outra',
            'ativo'          => 1,
          ]  
        ];
        
        foreach ($razoes as $razao) {
            \App\PontoRazao::create($razao);
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
