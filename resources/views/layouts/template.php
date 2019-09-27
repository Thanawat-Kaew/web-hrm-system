<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HRM | SYSTEM</title>
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
  <link href="https://fonts.googleapis.com/css?family=Kanit:300&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/resources/assets/css/main.css">
  <link rel="stylesheet" href="/resources/assets/css/leave/leave.css">
  <link rel="stylesheet" href="/resources/assets/css/personal_info/personal_info.css">
  <link rel="stylesheet" href="/resources/assets/css/time_stamp/index.css">
  <link rel="stylesheet" href="/resources/assets/css/data_management/index.css">

  <?php if (file_exists(base_path().'/resources/assets/css/'.helperGetModule().'/'.helperGetAction().'.css')): ?>
  <link rel="stylesheet" href="<?php echo '/resources/assets/css/'.helperGetModule().'/'.helperGetAction().'.css' ?>">
<?php endif ?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php echo view('layouts.topbar') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php echo view('layouts.sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php echo view($page, $data) ?>
    </div>
    <!-- /.content-wrapper -->

    <!--footer-->
    <?php echo view('layouts.footer')?>

    <!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/resources/assets/theme/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="/resources/assets/theme/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/resources/assets/theme/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="/resources/assets/theme/adminlte/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/resources/assets/theme/adminlte/dist/js/demo.js"></script>
<!-- bootstrap-datetimepickrt -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<!-- timepicker -->
<script src="/resources/assets/theme/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/resources/assets/js/core/bootstrap_datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!-- Time Picker -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap-daterangepicker/moment.min.js"></script>
<!-- bootbox -->
<script src="/resources/assets/js/core/bootbox/bootbox.min.js"></script>
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<!-- icheck -->
<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
<!-- main function -->
<script src="/resources/assets/js/main.js"></script>

<!-- <script src="/resources/assets/js/personal_info/personal_info.js"></script>
<script src="/resources/assets/js/data_management/index.js"></script>
<script src="/resources/assets/js/time_stamp/index.js"></script>
<script src="/resources/assets/js/time_stamp/time_stamp.js"></script>
<script src="/resources/assets/js/leave/leave.js"></script>
 -->
<?php if (file_exists(base_path().'/resources/assets/js/'.helperGetModule().'/'.helperGetAction().'.js')): ?>
<script src="<?php echo '/resources/assets/js/'.helperGetModule().'/'.helperGetAction().'.js' ?>"></script>
<?php endif ?>
<?php echo base_path().'/resources/assets/js/'.helperGetModule().'/'.helperGetAction().'.js'?>

</body>
</html>
