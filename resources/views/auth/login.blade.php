<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HR | M</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition login-page" style="background-color: #222d32;">
<div class="login-box">

  <div class="login-logo">
    <a style="color: white;"><b>HR-</b>MANAGEMENT</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="border-radius: 5px;">
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="{{ route('login') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" style="border-radius: 5px;">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" style="border-radius: 5px;">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius: 5px;">Sign In</button>
        </div><br><br>
       <!--  <a href="<?php /*echo route("admin_login")*/ ?>" class="pull-right"  style="margin-right: 15px;">
          <span class="label label-danger">For Admin</span>
        </a> -->
        <!-- /.col -->
      </div>
    </form>
  </div><br><br>
    @if(Session::has('fail'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p style="margin-bottom: 0;"><i class="icon fa fa-ban"></i> {{Session::get('fail')}}</p>
        </div>
    @endif
  <!-- /.login-box-body -->
  <!--  @if(Session::has('fail'))
    <div class="alert alert-warning alert-dismissible">
      <p>{{ \Session::get('fail') }}</p>
    </div>
    @endif -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
