<?php $url_base = getenv('APP_URL'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ getenv('APP_NAME') }} | Ponto Eletrônico | Painel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/d3cb21102b.js" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/iCheck/square/blue.css">
  
  <link href="{{ $url_base }}/adminlte/plugins/sweet-alert/sweet-alert.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
    
<div class="login-box">
  <div class="login-logo">
      <a href="#"><img src="{{ $url_base }}/img/ilab4_logo_pontoeletronico.png" width="350px;"></a>
  </div>
    
  <!-- /.login-logo -->
  <div class="login-box-body">
      <p class="login-box-msg"><b>Ponto Eletrônico | Painel</b></p>

    <form action="{{ $url_base }}/painel/login" method="post">
      {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" name="cpf" class="form-control cpf" placeholder="CPF" maxlength="14"  required>
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="password" name="senha" class="form-control" placeholder="Senha" maxlength="20" required>
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-md-8">
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
  
  <input type="hidden" id="url_base" value="{{ $url_base }}">
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ $url_base }}/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ $url_base }}/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ $url_base }}/adminlte/bower_components/iCheck/icheck.min.js"></script>

<script src="{{ $url_base }}/adminlte/plugins/sweet-alert/sweet-alert.min.js"></script>

<!-- InputMask -->
<script src="{{ $url_base }}/adminlte/bower_components/inputmask/jquery.mask.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script>
        $(document).ready(function(){
                $('.datemask').mask('00/00/0000');
                $('.telefone').mask('(00)00000-0000');
                $('.cpf').mask('000.000.000-00');
                $('.time').mask('00:00');
        });
</script>
<?php
if (Session::has('status.msg')){

    $error_msg = Session::get("status.msg");
    Session::forget('status.msg');
    
    if (isset($error_msg) AND $error_msg != ""):
        echo("<script>swal(\"$error_msg\");</script>");
    endif;
}    
?>   

<?php 
if(isset($error_redirect) AND $error_redirect != ""):
    header("location: $error_redirect");
endif;
?>
</body>
</html>
