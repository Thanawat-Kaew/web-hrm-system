<!DOCTYPE html>
<html>
<body class="content-wrapper">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Time | Stamp</title>
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
  <!--Clock-->
  <link rel="stylesheet" href="/resources/assets/css/time_stamp/time_stamp.css">


  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">

</head>

<section class="content-header">
    <h1>
        ลงเวลา
        <small>Version 1.0</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-10">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">TimeStamp</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="clock">
                            <div id="Date"></div>
                            <ul class="clock">
                                <li id="hours"> </li>
                                <li id="point">:</li>
                                <li id="min"> </li>
                                <li id="point">:</li>
                                <li id="sec"> </li>
                            </ul>
                        </div>
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" ธนวัฒน์  แก้วล้อมวัง">
                        </div><br>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-unlock"></i>
                            </div>
                            <input class="form-control" placeholder="" value="5951001063">
                        </div><br>
                        <div class="form-group">
                            <label>รูปแบบ</label>
                            <select class="form-control select2" style="width: 100%;">
                                <option selected="selected">ลงชื่อเข้า</option>
                                <!-- <option>ลงชื่อเข้า</option> -->
                                <option>พักกลางวัน</option>
                                <option>ลงชื่อออก</option>
                            </select>
                        </div><br>
                        <!-- /.input group -->
                        <a href="<?php echo route('main')?>">
                        <button class="btn btn-warning pull-right cancel" type="cancel">CANCEL</button></a>
                        <a href="">
                        <button class="btn btn-info pull-right submit" type="submit">SUBMIT</button></a>
                    </div>
                    <!-- /.form group -->
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/resources/assets/theme/adminlte/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/resources/assets/theme/adminlte/dist/js/demo.js"></script>
  <!--Clock-->
<script src="/resources/assets/js/time_stamp/time_stamp.js"></script>
</body>
</html>
