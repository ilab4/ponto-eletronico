<?php $url_base = getenv('URL_BASE'); ?>
<?php
$admin = Session::get('login.ponto.painel.admin');
?>
@extends('pontoeletronico.painel')

@section('conteudo')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Acompanhamento 
      </h1>
    </section>

    
       <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Filtrar por Mês</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
 
                <form name="form_add" method="POST" class="valid" action="/painel/acompanhamento">	
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data início (dd/mm/aaaa)</label>							
                                        <input type="text" value="<?=$data_inicio?>" name="data_inicio" class="form-control datepicker" />
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data fim (dd/mm/aaaa)</label>
                                        <input type="text" value="<?=$data_fim?>" name="data_fim" class="form-control datepicker" />
                                    </div>
                            </div>
                            
                            
                        </div>
                    </div>
                
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><span>Buscar</span></button>
                    </div>
                </form>    
            
            
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content --> 
    
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            @if($admin !== 1)
            <div class="box-header">
                <div class="col-md-6" style="padding-left: 0;">
                    <h3 class="box-title">Registros de: <b><?=$data_inicio?> a <?=$data_fim?></b></h3>
                </div>  
            </div>
            @endif
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="20%">Dia</th>
                  <th width="20%">Entrada</th>
                  <th width="20%">Saída</th>
                  <th width="20%">Tempo Trabalhado</th>
                  <th width="20%">Intervalo</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $registro_dia = '';
                $conta_registro = 0;
                $total_registro = count($registros);
                $horas_trabalhadas_total = 0;
                
                ?>
                @foreach($registros as $registro)
                    <?php
                    
                    $varData = '';
                    if($registro_dia != $registro->data):
                        $varData = $registro->data;
                        $data_arr = explode("-", $varData);
                        $varData = $data_arr[2].'/'.$data_arr[1].'/'.$data_arr[0];
                        $ultima_hora_saida = '';
                        if(isset($horas_trabalhadas_total_dia)):
                            $horas_trabalhadas_total_dia_bkp = $horas_trabalhadas_total_dia;
                            $horas_trabalhadas_total = $horas_trabalhadas_total + $horas_trabalhadas_total_dia;
                        endif;
                        $horas_trabalhadas_total_dia = 0;
                        $varData2 = $varData;
                    endif;
                    
                    
                    $horas_trabalhadas = '';
                    
                    if(!empty($registro->entrada) AND !empty($registro->saida)):
                        $entrada = new DateTime($registro->entrada);
                        $saida = new DateTime($registro->saida);
                        $intervalo = $saida->diff($entrada);
                        
                        $intervalo_hora = $intervalo->h;
                        if(strlen($intervalo->h) == 1):
                            $intervalo_hora = '0'.$intervalo->h;
                        endif;
                        
                        $intervalo_minuto = $intervalo->i;
                        if(strlen($intervalo->i) == 1):
                            $intervalo_minuto = '0'.$intervalo->i;
                        endif;
                        
                        $horas_trabalhadas = $intervalo_hora.':'.$intervalo_minuto;
                        
                        $horas_trabalhadas_total_dia = $horas_trabalhadas_total_dia + ($intervalo->h*60 + $intervalo->i);
                    
                        
                    endif;
                    
                    
                    
                    $intervalo_pausa = '';
                    
                    
                    if(!empty($ultima_hora_saida) AND !empty($registro->entrada)):
                        
                        $entrada = new DateTime($ultima_hora_saida);
                        $saida = new DateTime($registro->entrada);
                        $intervalo2 = $saida->diff($entrada);
                        
                        $intervalo2_hora = $intervalo2->h;
                        if(strlen($intervalo2->h) == 1):
                            $intervalo2_hora = '0'.$intervalo2->h;
                        endif;
                        
                        $intervalo2_minuto = $intervalo2->i;
                        if(strlen($intervalo2->i) == 1):
                            $intervalo2_minuto = '0'.$intervalo2->i;
                        endif;
                        
                        $intervalo_pausa = $intervalo2_hora.':'.$intervalo2_minuto;
                        
                    endif;
                    
                    $ultima_hora_saida = $registro->saida;
                    
                    
                    ?>
                    @if($registro_dia != $registro->data AND $registro_dia != '')
                        <?php
                        $horas_trabalhadas_total_dia_h = (int) ($horas_trabalhadas_total_dia_bkp / 60);
                        $horas_trabalhadas_total_dia_m = ($horas_trabalhadas_total_dia_bkp-($horas_trabalhadas_total_dia_h*60));
                        
                        if(strlen($horas_trabalhadas_total_dia_h) == 1):
                            $horas_trabalhadas_total_dia_h = '0'.$horas_trabalhadas_total_dia_h;
                        endif;
                        
                        if(strlen($horas_trabalhadas_total_dia_m) == 1):
                            $horas_trabalhadas_total_dia_m = '0'.$horas_trabalhadas_total_dia_m;
                        endif;
                        ?>
                        <tr>
                            <td colspan="4" align='right'><b>Total Trabalhado:</b></td>
                            <td><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
                        </tr>
                    @endif
                    <tr>
                      <td><b>{{ $varData }}</b></td>
                      <td>
                          @if($registro->entrada_status === NULL)
                            <a href="#modal-correcao-{{ $registro->id }}" data-toggle="modal" onclick="setaDadosModal({{ $registro->id }}, 'entrada', '<?=$varData2?>', '')"><i class="fas fa-exclamation-triangle text-yellow"></i></a>
                          @else
                            <?php
                            if ($registro->entrada_status == 0) $varCor = '#005599';
                            if ($registro->entrada_status == 1) $varCor = '#D39745';
                            if ($registro->entrada_status == 2) $varCor = '#67b021';
                            ?>
                            @if($registro->entrada_status != 0)
                                <span style="color: <?=$varCor?>;">{{ substr($registro->entrada, 0, 5) }}</span> 
                            @else
                                <a href="#modal-correcao-{{ $registro->id }}" style="color: <?=$varCor?>;" data-toggle="modal" onclick="setaDadosModal({{ $registro->id }}, 'saida', '<?=$varData2?>', '<?=substr($registro->entrada, 0, 5)?>')">{{ substr($registro->entrada, 0, 5) }}</a>
                            @endif
                          @endif
                      </td>
                      <td>
                          @if($registro->saida_status === NULL)
                            <a href="#modal-correcao-{{ $registro->id }}" data-toggle="modal" onclick="setaDadosModal({{ $registro->id }}, 'saida', '<?=$varData2?>', '')"><i class="fas fa-exclamation-triangle text-yellow"></i></a>
                          @else
                            <?php
                            if ($registro->saida_status == 0) $varCor = '#005599';
                            if ($registro->saida_status == 1) $varCor = '#D39745';
                            if ($registro->saida_status == 2) $varCor = '#67b021';
                            ?>
                            @if($registro->saida_status != 0)
                                <span style="color: <?=$varCor?>;">{{ substr($registro->saida, 0, 5) }}</span> 
                            @else
                                <a href="#modal-correcao-{{ $registro->id }}" style="color: <?=$varCor?>;" data-toggle="modal" onclick="setaDadosModal({{ $registro->id }}, 'saida', '<?=$varData2?>', '<?=substr($registro->saida, 0, 5)?>')">{{ substr($registro->saida, 0, 5) }}</a>
                            @endif
                          @endif
                      </td>
                      <td><?=$horas_trabalhadas?></td>
                      <td><?=$intervalo_pausa?></td>
                    </tr>
                    <?php
                    $registro_dia = $registro->data;
                    $conta_registro++;
                    ?>
                    
                    @if($conta_registro == $total_registro)
                    
                        <?php
                        $horas_trabalhadas_total = $horas_trabalhadas_total + $horas_trabalhadas_total_dia;
                        
                        $horas_trabalhadas_total_dia_h = (int) ($horas_trabalhadas_total_dia / 60);
                        $horas_trabalhadas_total_dia_m = ($horas_trabalhadas_total_dia-($horas_trabalhadas_total_dia_h*60));
                        
                        if(strlen($horas_trabalhadas_total_dia_h) == 1):
                            $horas_trabalhadas_total_dia_h = '0'.$horas_trabalhadas_total_dia_h;
                        endif;
                        
                        if(strlen($horas_trabalhadas_total_dia_m) == 1):
                            $horas_trabalhadas_total_dia_m = '0'.$horas_trabalhadas_total_dia_m;
                        endif;
                        ?>
                        <tr>
                            <td colspan="4" align='right'><b>Total Trabalhado:</b></td>
                            <td><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
                        </tr>
                        
                        <?php
                        $horas_trabalhadas_total_h = (int) ($horas_trabalhadas_total / 60);
                        $horas_trabalhadas_total_m = ($horas_trabalhadas_total-($horas_trabalhadas_total_h*60));
                        
                        if(strlen($horas_trabalhadas_total_h) == 1):
                            $horas_trabalhadas_total_h = '0'.$horas_trabalhadas_total_h;
                        endif;
                        
                        if(strlen($horas_trabalhadas_total_m) == 1):
                            $horas_trabalhadas_total_m = '0'.$horas_trabalhadas_total_m;
                        endif;
                        ?>
                        <tr>
                            <td colspan="4" align='right'><b>Total trabalhado no período de <span style="color: #900;"><?=$data_inicio?></span> a <span style="color: #900;"><?=$data_fim?></span>:</b></td>
                            <td><b><?=$horas_trabalhadas_total_h?>:<?=$horas_trabalhadas_total_m?></b></td>
                        </tr>
                    
                    @endif
                    
                    
                    
                    <div id="modal-correcao-{{ $registro->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h2 class="modal-title">Pedido de Ajuste</h2>
                                </div>

                                <form method="post" action="/painel/ponto/salvar" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="modal-body">

                                                <input type="hidden" name="ponto_id" value="{{ $registro->id }}">

                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                    <label>Tipo:</label><br>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                    <input type="radio" name="tipo" class="tipo-ajuste" id="tipo-entrada-{{ $registro->id }}" data-id='<?=$registro->id?>' value="entrada"> Entrada
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                    <input type="radio" name="tipo" class="tipo-ajuste" id="tipo-saida-{{ $registro->id }}" data-id='<?=$registro->id?>' value="saida"> Saída
                                                    </div>
                                                    
<!--                                                    <div class="col-md-3">
                                                    <input type="radio" name="tipo" class="tipo-ajuste" id="tipo-periodo-{{ $registro->id }}" data-id='<?=$registro->id?>' value="periodo"> Período
                                                    </div>-->
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-md-4">
                                                        <input type="text" name="data" id="data-{{ $registro->id }}" class="form-control" placeholder="Data" value="" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group" id="hora-simples-{{ $registro->id }}">
                                                    <div class="col-md-4">
                                                        <input type="text" name="hora" id="hora-{{ $registro->id }}" class="form-control time" placeholder="Hora" value="">
                                                    </div>
                                                </div>

                                                <div class="row form-group" id="hora-periodo-{{ $registro->id }}" style="display: none;">
                                                    <div class="col-md-4">
                                                        <input type="text" name="hora_entrada" id="hora_entrada-{{ $registro->id }}" class="form-control" placeholder="Hora de Entrada" value="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="hora_saida" id="hora_saida-{{ $registro->id }}" class="form-control" placeholder="Hora de Saída" value="">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Justificativa</label>
                                                    <select name="justificativa" class="form-control" required>
                                                        <option value=""></option>
                                                        @foreach($justificativas as $justificativa)
                                                        <option value="{{ $justificativa->id }}">{{ $justificativa->descricao }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Anexo</label>
                                                    <input type="file" name="anexo">
                                                </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>

                                </form>
                                <br>
                            </div>
                        </div>
                    </div>
                
                
                @endforeach 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection