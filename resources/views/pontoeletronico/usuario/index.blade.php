<?php $url_base = getenv('URL_BASE'); ?>
@extends('pontoeletronico.painel')

@section('conteudo')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Colaboradores 
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
                <div class="col-md-6" style="padding-left: 0;">
                    <h3 class="box-title">Listagem de Colaboradores</h3>
                </div>  
                <div class="col-md-6 text-right">
                    <a href='usuario/novo' class="btn btn-md btn-success"><i class="fa fa-plus"></i> Novo Colaborador</a>
                </div>  
              
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>CPF</th>
                  <th>Cargo</th>
                  <th>Local</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                      <td>{{ utf8_decode($usuario->nome) }}</td>
                      <td>{{ $usuario->email }}</td>
                      <td>{{ $usuario->cpf }}</td>
                      <td>{{ $usuario->cargo }}</td>
                      <td>{{ $usuario->local }}</td>
                      <td>{{ ($usuario->ativo == 1) ? "Ativo" : "Inativo" }}</td>
                      <td>
                          <a href='{{ $url_base }}/painel/usuario/editar/{{ $usuario->id }}' class="btn btn-xs btn-default"><i class="fa fa-pencil"></i> Editar</a>
                          @if($usuario->admin != 1)
                              @if($usuario->ativo == 1)
                                <a href='#' data-url="{{ $url_base }}/painel/usuario/desabilitar/{{ $usuario->id }}" data-msg="Deseja desabilitar esse colaborador?" class="btn btn-xs btn-danger btnExluir"><i class="fa fa-ban"></i> Desabilitar</a>
                              @else
                                <a href='#' data-url="{{ $url_base }}/painel/usuario/habilitar/{{ $usuario->id }}" data-msg="Deseja habilitar esse colaborador?" class="btn btn-xs btn-success btnExluir"><i class="fa fa-ban"></i> Habilitar</a>
                              @endif
                          @else
                          <span class="badge bg-black">Usuário Administrador</span>
                          @endif
                      </td>
                    </tr>
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