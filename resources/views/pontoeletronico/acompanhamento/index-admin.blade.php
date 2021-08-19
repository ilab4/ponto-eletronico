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
              <h3 class="box-title">Filtrar por Período</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
 
                <form name="form_add" method="POST" class="valid" action="/painel/acompanhamento">	
                    {{ csrf_field() }}
                    <div class="box-body">
                        @if($usuarios)
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Colaborador</label>							
                                        <select name="usuario" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="all">TODOS</option>
                                            @if($usuarios)
                                            @foreach($usuarios as $u)
                                            <option value="{{ $u->id }}">{{ $u->nome }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                            </div>
                        </div>
                        @endif
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
            @if($admin === '1')
            <?php
            $data_inicio_arr = explode("/", $data_inicio);
            $data_inicio = $data_inicio_arr[2].'-'.$data_inicio_arr[1].'-'.$data_inicio_arr[0];
            
            $data_fim_arr = explode("/", $data_fim);
            $data_fim = $data_fim_arr[2].'-'.$data_fim_arr[1].'-'.$data_fim_arr[0];
            ?>
<!--            <div class="box-header">
                <div class="col-md-6" style="padding-left: 0;">
                </div>
                <div class="col-md-6 text-right">
                    <a href='excel-acompanhamento/all/{{ $data_inicio }}/{{ $data_fim }}' data-toggle="modal" class="btn btn-xs btn-default"><i class="fa fa-file-excel-o"></i> Exportar Todos</a>
                </div>  
            </div> -->
            @endif
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                
              <div class="box-group" id="accordion">  
                
                @foreach ($data as $nome => $registros)
                
                    @php
                    $registro_dia = '';
                    $conta_registro = 0;
                    $total_registro = count($registros);
                    $horas_trabalhadas_total = 0;
                    $horas_trabalhadas_total_dia = 0;
                    $registro_nome = str_replace(" ", "", $nome);
                    @endphp
                    
                    @if($conta_registro == 0)
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <div class="col-md-6">
                                <h4 class="box-title">
                                    
                                    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $registro_nome }}" aria-expanded="false" class="collapsed">
                                        {{ strtoupper($nome) }}
                                    </a>
                                    
                                </h4>
                                </div>     
                                <div class="col-md-6 text-right">
                                    <a href='excel-acompanhamento/{{ $nome }}/{{ $data_inicio }}/{{ $data_fim }}' data-toggle="modal" class="btn btn-xs btn-default"><i class="fa fa-file-excel-o"></i> Exportar</a>
                                </div>    
                            </div>
                            <div id="{{ $registro_nome }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                              <th width="15%">Dia</th>
                                              <th width="10%">Entrada</th>
                                              <th width="10%">Saída</th>
                                              <th width="10%">Tempo Trabalhado</th>
                                              <th width="10%">Intervalo</th>
                                              <th width="45%">Obs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    @endif
                    
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
                                <td colspan="3" align='right'><b>Total Trabalhado:</b></td>
                                <td colspan="3"><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
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
                          <td>
                              <?php
                              $ajustes = App\PontoAjuste::where('ponto_id', '=', $registro->id)->whereIn('status', array(1, 2))->orderBy('created_at', 'ASC')->get();
                              ?>
                              @foreach($ajustes as $ajuste)
                                @if($ajuste->status == 1)
                                    <span class="badge bg-green">Aprovado em {{ $ajuste->updated_at->format('d/m/Y') }}</span>
                                @else
                                    <span class="badge bg-red">Não Aprovado em {{ $ajuste->updated_at->format('d/m/Y') }}</span>
                                @endif
                                @if(!empty($ajuste->obs_supervisor))
                                    {{ $ajuste->obs_supervisor }}
                                @endif
                                @if(!empty($ajuste->anexo))
                                    <a href='../upload/razao/{{ $ajuste->anexo }}' class="btn btn-xs btn-default" target='blank'>Anexo</a>
                                @endif
                                <br>
                              @endforeach
                          </td>
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
                                <td colspan="3" align='right'><b>Total Trabalhado:</b></td>
                                <td colspan="3"><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
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
                                <td colspan="3" align='right'><b>Total trabalhado no período de <span style="color: #900;"><?=$data_inicio?></span> a <span style="color: #900;"><?=$data_fim?></span> ({{ strtoupper($nome) }}):</b></td>
                                <td colspan="3"><b><?=$horas_trabalhadas_total_h?>:<?=$horas_trabalhadas_total_m?></b></td>
                            </tr>

                        @endif

                    @endforeach 
                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                
                @endforeach 
                
              
              </div>
                
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