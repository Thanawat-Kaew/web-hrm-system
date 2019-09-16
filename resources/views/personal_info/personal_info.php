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
    <link rel="stylesheet" href="/resources/assets/css/main.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <section class="content">
            <h3>ข้อมูลส่วนตัว <small>| Personal Information</small></h3>
            <div class="row">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="text-center">
                            <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                        </div>
                        รหัสพนักงาน
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-key"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" 5951001063">
                        </div>
                        ชื่อ - นามสกุล
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" ธนวัฒน์  แก้วล้อมวัง">
                        </div>
                        ตำแหน่ง
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" Web Developer">
                        </div>
                        แผนก
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-sitemap"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" Information Technology">
                        </div>
                        อัตราเงินเดือน
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" 50,000">
                        </div>
                        การศึกษา
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" ปริญญาตรี">
                        </div>
                        อายุ
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa  fa-circle-o"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" 22">
                        </div>
                        ที่อยู่
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" กรุงเทพมหานคร  ประเทศไทย">
                        </div>
                        อีเมล์
                        <div class="input-group name_user">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" tanawat@example.com">
                        </div><br>

                        <div class="form-group text-center">
                            <a href="<?php echo route('main')?>">
                                <button class="btn btn-info pull-center" type="submit">BACK</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
