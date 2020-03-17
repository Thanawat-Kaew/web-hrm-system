<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HRM | Main</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/plugins/iCheck/all.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/plugins/timepicker/bootstrap-timepicker.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="/resources/assets/theme/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" type="text/css" href="/resources/assets/js/core/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css" href="/resources/assets/js/core/sweetalert2/sweetalert2.min.css">
  <link href="/resources/assets/theme/adminlte/plugins/timepicker/bootstrap-timepicker.min.css" type="text/css" rel="stylesheet">
  <link href="/resources/assets/theme/adminlte/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" type="text/css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/resources/assets/css/admin/admin_main.css">
</head>
<body>
    <div class="content" style="margin-top: 10%;">
        <!-- mobile -->
        <div class="col-md-8 col-md-offset-2 hidden-md hidden-sm hidden-lg">
            <section class="content-header content-admin-menu">
                <h1>
                    Admin Management
                    <small>Version 1.0.0</small>
                    <a class="pull-right logout">
                        <i class="glyphicon glyphicon-log-in"></i>
                    </a>
                </h1>
            </section>
            <hr>
            <section class="content">
                <div class="row">
                    <div class="col-md-3 col-offset-md-4">
                        <a href="<?php echo route('admin.add_header_emp.get')?>">
                            <img src="/resources/image/add_header.png" class="image-menu-admin" style="width: 150px; height: 50px; border-radius: 5px; margin: 5px;">
                        </a>
                    </div>
                    <div class="col-md-3 col-offset-md-4">
                        <a href="<?php echo route('admin.add_department.get')?>">
                            <img src="/resources/image/add_department.png" class="image-menu-admin" style="width: 150px; height: 50px; border-radius: 5px; margin: 5px;">
                        </a>
                    </div>
                    <div class="col-md-3 col-offset-md-4">
                        <a href="<?php echo route('admin.log.get')?>">
                            <img src="/resources/image/log.png" class="image-menu-admin" style="width: 150px; height: 50px; border-radius: 5px; margin: 5px;">
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <!-- desktop -->
        <div class="col-md-8 col-md-offset-2  hidden-xs">
            <section class="content-header">
                <h1>
                   Admin Management
                    <small>Version 1.0.0</small>
                    <a class="pull-right logout">
                     <i class="glyphicon glyphicon-log-in"></i>
                 </a>
             </h1>
         </section>
         <hr>
         <section class="content">
            <div class="row">
                <div class="col-md-3 col-offset-md-4">
                    <a href="<?php echo route('admin.add_header_emp.get')?>">
                        <img src="/resources/image/add_header.png" class="image-menu-admin" style="width: 210px; height: 70px; border-radius: 5px;">
                    </a>
                </div>
                <div class="col-md-3 col-offset-md-4">
                    <a href="<?php echo route('admin.add_department.get')?>">
                        <img src="/resources/image/add_department.png" class="image-menu-admin" style="width: 210px; height: 70px; border-radius: 5px;">
                    </a>
                </div>
                <div class="col-md-3 col-offset-md-4">
                    <a href="<?php echo route('admin.log.get')?>">
                        <img src="/resources/image/log.png" class="image-menu-admin" style="width: 210px; height: 70px; border-radius: 5px;">
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- data -->
<div id="logout-form" data-url="<?php echo route('logout.index.post') ?>"></div>
<?php echo csrf_field()?>

<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
<!-- icheck -->
<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
<!-- Sweet Alert -->
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<!--Clock-->
<!-- datepicker -->

<script src="/resources/assets/js/admin/admin_main.js"></script>
</body>
</html>
