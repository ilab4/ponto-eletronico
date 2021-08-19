<?php $url_base = getenv('URL_BASE'); ?>
<?php
if(isset($u)):

    $acao = "editar";
    $return_id = $u->id;
    $return_nome = utf8_decode($u->nome);
    $return_email = $u->email;
    $return_cpf = $u->cpf;
    $return_senha = $u->senha;
    $return_cargo = $u->cargo;
    $return_admin = $u->admin;
    $return_local = $u->local;
    $return_ativo = $u->ativo;
    $varCheckAtivo = ($return_ativo == 1)? 'checked' : '';
    $varRequired = '';
        
else:    

    $acao = "novo";
    $return_id = '';
    $return_nome = '';
    $return_email = '';
    $return_cpf = '';
    $return_senha = '';
    $return_cargo = '';
    $return_admin = '';
    $return_local = '';
    $varCheckAtivo = 'checked';
    $varRequired = 'required';
    
endif;
?>


@extends('pontoeletronico.painel')

@section('conteudo')

<!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Colaboradores
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
              <h3 class="box-title">Cadastrar/Editar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            
            <form id="formUsuario" method="post" action="{{ $url_base }}/painel/usuario/salvar">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="<?php print $return_id; ?>">
                <input type="hidden" name="email_banco" value="<?php print $return_email; ?>">
                <input type="hidden" name="cpf_banco" value="<?php print $return_cpf; ?>">
                <input type="hidden" name="admin" value="<?php print $return_admin; ?>">
                <!-- text input -->

                <div class="box-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="nome" maxlength="100" value="<?php print $return_nome; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" maxlength="100" value="<?php print $return_email; ?>" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cargo</label>
                                    <input type="text" name="cargo" maxlength="100" value="<?php print $return_cargo; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Local</label>
                                    <input type="text" name="local" maxlength="100" value="<?php print $return_local; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" maxlength="14" value="<?php print $return_cpf; ?>" class="form-control cpf" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" id="senha" name="senha" maxlength="12" class="form-control" <?php print $varRequired; ?> >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirmar senha</label><small id="has-error-resenha"></small>
                                    <input type="password" id="resenha" name="resenha" maxlength="12" class="form-control" <?php print $varRequired; ?> >
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="ativo" <?php print $varCheckAtivo; ?>>
                              Ativo
                            </label>
                          </div>
                        </div>
                    
                    
                </div>

                <div class="box-footer">
                    <button type="submit" id="razao-salvar" class="btn btn-primary btnCadastro pull-right">Salvar</button>
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
    
@endsection