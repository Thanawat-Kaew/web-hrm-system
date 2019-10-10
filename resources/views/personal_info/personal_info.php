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
    <link rel="stylesheet" type="text/css" href="/resources/assets/js/core/sweetalert2/sweetalert2.min.css">
    

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php echo view('layouts.topbar') ?>
    <div class="container">
        <section class="content">
            <h3>ข้อมูลส่วนตัว <small>| Personal Information</small></h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <?php if(\Session::has('current_employee')) :?>
                                <div class="text-center">
                                    <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                                </div>
                                <div class="personal-data">
                                 <?php $current_employee = \Session::get('current_employee') ?>
                                 <h4>รหัสพนักงาน :  <?php echo $current_employee['id_employee'] ?> </h4>
                                 <h4>ชื่อ - สกุล :   <?php echo $current_employee['first_name'] ?> <?php echo $current_employee['last_name'] ?></h4>
                                 <h4>ตำแหน่ง :    <?php echo $name_position['name'] ?></h4>
                                 <h4>แผนก :  <?php echo $name_department['name'] ?></h4>
                                 <h4>อัตราเงินเดือน : <?php echo $current_employee['salary'] ?> </h4>
                                 <h4>การศึกษา :  <?php echo $current_employee['education'] ?> </h4>
                                 <h4>เพศ :  <?php echo $current_employee['gender'] ?> </h4>
                                 <h4>อายุ :  <?php echo $current_employee['age'] ?> </h4>
                                 <h4>ที่อยู่ :  <?php echo $current_employee['address'] ?> </h4>
                                 <h4>อีเมล์ :  <?php echo $current_employee['email'] ?> </h4>
                                 <h4>เบอร์โทรศัพท์ : <?php echo $current_employee['tel'] ?> </h4>
                                 
                             </div><hr>
                             <div class="form-group text-center about-menu">
                                <a href="<?php echo route('main.get')?>">
                                    <button class="btn btn-info pull-center" type="submit">กลับสู่หน้าหลัก</button>
                                </a>
                                <a>
                                    <button class="btn btn-warning pull-center amendment" data-id="<?php echo $current_employee['id_employee'] ?>" type="submit">แจ้งแก้ไขข้อมูล</button>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        ประวัติการแก้ไขข้อมูล
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ครั้งที่</th>
                                <th>วันที่</th>
                                <th>สถานะ</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>11-7-2014 19:08:00</td>
                                <td><span class="label label-success">อนุมัติแล้ว</span></td>
                                <td><button class="btn btn-warning form-control disabled"><i class="fa fa-pencil btn disabled"></i></button></td>
                                <td><button class="btn btn-danger form-control disabled"><i class="fa fa-trash btn disabled"></i></button>
                                </td>
                                <td><i class="fa fa-eye fa-lg btn"></i></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>11-7-2014 09:48:30</td>
                                <td><span class="label label-warning">กำลังรอ</span></td>
                                <td><span class="btn btn-warning form-control"><i class="fa fa-pencil btn"></i></span></td>
                                <td><span class="btn btn-danger form-control"><i class="fa fa-trash btn"></i></span></td>
                                <td><i class="fa fa-eye fa-lg btn"></i></td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('personal_info.ajax_center.post')?>"></div>
<?php echo csrf_field()?>

<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- bootbox -->
<script src="/resources/assets/js/core/bootbox/bootbox.min.js"></script>
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<script src="/resources/assets/js/personal_info/personal_info.js"></script>
<script src="/resources/assets/js/main.js"></script>
</html>


