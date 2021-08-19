<?php $url_base = getenv('APP_URL'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ getenv('APP_NAME') }} | Ponto Eletrônico</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/d3cb21102b.js" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/datatables/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/dist/css/AdminLTE.min.css">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  
  <link href="{{ $url_base }}/adminlte/plugins/fileuploader/font/font-fileuploader.css" rel="stylesheet">
  <link href="{{ $url_base }}/adminlte/plugins/fileuploader/css/jquery.fileuploader.min.css" media="all" rel="stylesheet">
  <link href="{{ $url_base }}/adminlte/plugins/fileuploader/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">

    <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="{{ $url_base }}/adminlte/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .box.box-primary {
        border-top-color: #000000 !important;
    }
  </style>
</head>
<body class="hold-transition skin-black sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  
    
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo" style="text-align: left !important;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ $url_base }}/img/apple-touch-icon.png"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ $url_base }}/img/ilab4_logo_pontoeletronico.png"></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <span class="hidden-xs">{{ utf8_decode(Session::get('login.ponto.usuario_nome')) }}</span>
            </a>
            
          </li>
        </ul>
      </div>
    </nav>
  </header>  
    

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ $url_base }}/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ utf8_decode(Session::get('login.ponto.usuario_nome')) }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- /.search form -->  
        
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        
        
        <li>
          <a href="<?php print $url_base; ?>/sair">
            <i class="fa fa-sign-out"></i>
            <span>Sair</span>
          </a>
        </li>
        
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
     
    @yield('conteudo')  
    
    
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; {{ Date("Y") }} <a href="https://ilab4.me">{{ getenv('APP_NAME') }}</a>.</strong> Todos os direitos reservados.
  </footer>

 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
  <input type="hidden" id="url_base" value="{{ $url_base }}">
  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ $url_base }}/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ $url_base }}/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="{{ $url_base }}/adminlte/bower_components/datatables/jquery.dataTables.min.js"></script>
<script src="{{ $url_base }}/adminlte/bower_components/datatables/dataTables.bootstrap.min.js"></script>
<!-- datepicker -->
<script src="{{ $url_base }}/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ $url_base }}/adminlte/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<!-- Slimscroll -->
<script src="{{ $url_base }}/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ $url_base }}/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ $url_base }}/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>

<script src="{{ $url_base }}/adminlte/plugins/ckeditor/ckeditor.js"></script>

<!-- ChartJS -->
<script src="{{ $url_base }}/adminlte/bower_components/chart.js/Chart.js"></script>

<!-- bootstrap color picker -->
<script src="{{ $url_base }}/adminlte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<script src="{{ $url_base }}/adminlte/dist/js/jquery.mask.min.js"></script>
<script src="{{ $url_base }}/adminlte/dist/js/site.js"></script>


<script src="{{ $url_base }}/adminlte/plugins/fileuploader/js/jquery.fileuploader.min.js" type="text/javascript"></script>
<script src="{{ $url_base }}/adminlte/plugins/fileuploader/js/custom.js?id=1" type="text/javascript"></script>


<script>
    $(document).ready(function(){
            $('.datemask').mask('00/00/0000');
            $('.telefone').mask('(00)00000-0000');
            $('.cpf').mask('000.000.000-00');
            $('.time').mask('00:00');
    });
</script>

<script>
$(document).on('click', '.btnExluir', function(e) {
    
    event.preventDefault();
    
    var url = $(this).data('url');
    var msg = $(this).data('msg');
    
    swal({
        title: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: true,
        closeOnCancel: true
      },
      function(isConfirm){
        if (isConfirm) {
            window.location.href = url;
        }
      });
    
});    
</script>

<script>
    CKEDITOR.replace( 'editor1', {
            height: 400
    } );
</script>
<script>
    CKEDITOR.replace( 'editor2', {
            height: 180
    } );
</script>
<script>
    CKEDITOR.replace( 'editor3', {
            height: 180
    } );
</script>
<script>
  $(function () {

    $("#example1").DataTable();
   
  });
  
</script>

<script>
    $(function () {

      //Date picker
      var datepicker = $.fn.datepicker.noConflict();
      $.fn.bootstrapDP = datepicker;

      $(".datepicker").bootstrapDP({
          autoclose: true,
          format: "dd/mm/yyyy", 
          language: "pt-BR",
          showOtherMonths: true,
          selectOtherMonths: true,
          todayHighlight: true,
          nextText: "Próximo",
          prevText: "Anterior"
      });
      
      $("#datepicker").bootstrapDP({
          autoclose: true,
          format: "dd/mm/yyyy", 
          language: "pt-BR",
          showOtherMonths: true,
          selectOtherMonths: true,
          todayHighlight: true,
          nextText: "Próximo",
          prevText: "Anterior"
      });
            
      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()


    });
</script>


<?php
if (Session::has('status.msg_confirm')){

    $error_msg_confirm = Session::get("status.msg_confirm");
    $error_redir_confirm = Session::get("status.redir_confirm");
    Session::forget('status.msg_confirm');
    Session::forget('status.redir_confirm');
    
    if (isset($error_msg_confirm) AND $error_msg_confirm != ""):
    ?>

        <script>
            swal({
                title: "<?=$error_msg_confirm?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00a65a",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                closeOnConfirm: true,
                closeOnCancel: true,
                html: false
              },
              function(){
                    window.location.href = '<?=$error_redir_confirm?>';
              });
        </script>    
    <?php
    endif;
}    
?> 

<?php
if (Session::has('status.msg')){
    
    $error_redirect = Session::get("status.error_redirect");
    $error_msg = Session::get("status.msg");
    Session::forget('status.msg');
    Session::forget('status.error_redirect');
    
    if (isset($error_redirect) AND $error_redirect != ""):
        echo("<script>
              swal({
                title: \"$error_msg\",
                type: \"success\",
                timer: 3000,
                showConfirmButton: false
              }, function(){
                    window.location.href = \"$error_redirect\";
              });</script>");
    else:
        echo("<script>swal(\"$error_msg\");</script>");
    endif;
    
    
}    
?>   



</body>
</html>
