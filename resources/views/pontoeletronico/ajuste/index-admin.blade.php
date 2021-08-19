<?php $url_base = getenv('URL_BASE'); ?>
@extends('pontoeletronico.painel')

@section('conteudo')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Solicitações de Ajuste 
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        
      <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Instruções</h4>
        Clique no nome do colaborador para ver mais informações sobre o pedido.
      </div>  
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Data do Pedido</th>
                  <th width="10%">Colaborador</th>
                  <th width="10%">Registro</th>
                  <th width="10%">Dia</th>
                  <th width="10%">Hora</th>
                  <th width="30%">Justificativa</th>
                  <th width="10%">Anexo</th>
                  <th width="5%">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $registro_dia = '';
                
                ?>
                @foreach($solicitacoes as $solicitacao)
                    
                    <tr>
                      <td>{{ $solicitacao->created_at->format("d/m/Y H:i:s") }}</td>
                      <td><a href="#modal-aprovacao-{{ $solicitacao->id }}" data-toggle="modal">{{ $solicitacao->usuario->nome }}</a></td>
                      <td>{{ ucfirst($solicitacao->tipo) }}</td>
                      <td>{{ $solicitacao->data->format("d/m/Y") }}</td>
                      <td>{{ substr($solicitacao->hora, 0, 5) }}</td>
                      <td>{{ $solicitacao->pontoRazao->descricao }}</td>
                      <td>
                          @if(empty($solicitacao->anexo))
                            Sem anexo
                          @else  
                            <a href="{{ $url_base }}/upload/razao/{{ $solicitacao->anexo }}">{{ $solicitacao->anexo }}</a></td>
                          @endif
                      <td>
                         @if($solicitacao->status == 0) 
                            Pendente
                         @endif
                         
                         @if($solicitacao->status == 1)
                            Aprovado
                         @endif
                         
                         @if($solicitacao->status == 2)
                            Não aprovado
                         @endif
                      </td>
                      
                    </tr>
                    
                    <div id="modal-aprovacao-{{ $solicitacao->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h2 class="modal-title">Informações do Pedido</h2>
                                </div>

                                <form method="post" action="/painel/certificacao/salvar" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="modal-body">

                                                <input type="hidden" name="solicitacao_id" value="{{ $solicitacao->id }}">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                    
                                                    <p>    
                                                        <label>Colaborador:</label>: {{ $solicitacao->usuario->nome }}<br>
                                                        <label>Data do pedido:</label>: {{ $solicitacao->created_at->format("d/m/Y H:i:s") }}
                                                    </p>
                                                    
                                                    <p>
                                                        <label>Tipo:</label>: {{ ucfirst($solicitacao->tipo) }}<br>
                                                        <label>Data:</label>: {{ $solicitacao->data->format("d/m/Y") }}<br>
                                                        <label>Hora:</label>: {{ substr($solicitacao->hora, 0, 5) }}<br>
                                                        <label>Justificativa:</label>: {{ $solicitacao->pontoRazao->descricao }}<br>
                                                        <label>Anexo:</label>: 
                                                        @if(empty($solicitacao->anexo))
                                                            Sem anexo
                                                        @else  
                                                            <a href="{{ $url_base }}/upload/razao/{{ $solicitacao->anexo }}">{{ $solicitacao->anexo }}</a></td>
                                                        @endif
                                                    </p>
                                                    
                                                    <br>
                                                    
                                                    <p>
                                                    <div class="box box-success">
                                                        <div class="box-header with-border">
                                                          <h3 class="box-title">Certificação</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <label>Justificativa:</label>
                                                            <textarea name="obs" class="form-control"></textarea>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                    </p>
                                                      
                                                    </div>
                                                </div>
                                                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                                        <button type="submit" name="botao" value="sim" class="btn btn-success">Aprovar</button>
                                        <button type="submit" name="botao" value="nao" class="btn btn-danger">Não aprovar</button>
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
    
    <div id="modal-solicitacao" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title">Solicitação de Inclusão de Ajuste</h2>
                </div>

                <form method="post" action="/painel/ponto/periodo/salvar" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="modal-body">

                                <!--<input type="hidden" name="ponto_id" value="">-->
                                <input type="hidden" name="tipo" value="periodo">


                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <input type="text" name="data" class="form-control datepicker" placeholder="Data" value="" required>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <input type="text" name="hora_entrada" class="form-control time" placeholder="Hora de Entrada" value="" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="hora_saida" class="form-control time" placeholder="Hora de Saída" value="" required>
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
    
@endsection