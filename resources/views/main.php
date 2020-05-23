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
<body>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-6 hidden-md hidden-sm hidden-lg">
                <div class="lockscreen-wrapper">
                    <div class="text-center">
                        <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle hidden-xs" alt="User Image">
                        <h4>HUMAN RESOURCE MANAGEMENT SYSTEM
                        </h4>
                        <hr>
                        <h5>ระบบบริหารจัดการทรัพยากรบุคคล</h5>
                        <button class="btn btn-default logout"><i class="fa fa-sign-out"></i> Logout</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6  hidden-xs"  style="padding-top: 70px !important;">
                <!-- Automatic element centering -->
                <div class="lockscreen-wrapper">
                    <div class="links">
                        <div class="col-sm-12 col-xs-12">
                            <?php if(\Session::has('current_menu')) :  ?>
                                <?php
                                $menu_list   = \Session::get('current_menu');
                                $count_menu  = count((array) $menu_list);
                                ?>
                                <?php foreach($menu_list as $key => $menu):?>
                                    <?php $row_max = $key + 1;?>
                                    <?php if ($count_menu % 3 == 0 && $count_menu % 6 != 0):?>
                                        <div class="col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">
                                            <?php else:?>
                                                <div class="col-sm-6 col-xs-6">
                                                <?php endif ?>

                                                <a href="<?php echo route ($menu->route)  ?>">
                                                    <img class="image_menu" src="<?php echo 'resources/image/'.$menu->image ?>">
                                                </a>
                                            </div>
                                            <?php if ($count_menu % 3 == 0 && $count_menu % 6 != 0 && $row_max != $count_menu): ?>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <?php elseif($row_max == $count_menu):?>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    <?php if ($count_menu % 3 != 0 && $count_menu % 6 == 0): ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

            <div class="col-md-6  hidden-md hidden-sm hidden-lg">
                <!-- Automatic element centering -->
                <div class="lockscreen-wrapper">
                    <div class="links">
                        <div class="col-sm-12 col-xs-12">
                            <?php if(\Session::has('current_menu')) :  ?>
                                <?php
                                $menu_list   = \Session::get('current_menu');
                                $count_menu  = count((array) $menu_list);
                                ?>
                                <?php foreach($menu_list as $key => $menu):?>
                                    <?php $row_max = $key + 1;?>
                                    <?php if ($count_menu % 3 == 0 && $count_menu % 6 != 0):?>
                                        <div class="col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">
                                            <?php else:?>
                                                <div class="col-sm-6 col-xs-6">
                                                <?php endif ?>

                                                <a href="<?php echo route ($menu->route)  ?>">
                                                    <img class="image_menu" src="<?php echo 'resources/image/'.$menu->image ?>">
                                                </a>
                                            </div>
                                            <?php if ($count_menu % 3 == 0 && $count_menu % 6 != 0 && $row_max != $count_menu): ?>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <?php elseif($row_max == $count_menu):?>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    <?php if ($count_menu % 3 != 0 && $count_menu % 6 == 0): ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                    <!-- PC -->
                    <div class="col-md-6">
                        <div class="lockscreen-wrapper pull-left hidden-xs">
                            <div class="text-center" style="margin-top: 130px;">
                                <?php if(!empty($current_employee->image)){?> <!-- ถ้ามีรูป  -->
                                <img src="/public/image/<?php echo $current_employee->image ?>" class="user-image img-circle" alt="User Image" style="width: 160px; height: 160px;">
                                <?php }else{?> <!-- ถ้าไม่มีรุป -->
                                <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                                <?php } ?>
                                <h5><?php echo $current_employee->first_name ?> <?php echo $current_employee->last_name ?></h5>
                                <hr>
                                <h4>HUMAN RESOURCE MANAGEMENT SYSTEM</h4>
                                <h5>ระบบบริหารจัดการทรัพยากรบุคคล</h5>

                                <button class="btn btn-default logout"><i class="fa fa-sign-out"></i> Logout</button>
                                <!-- Notifications: style can be found in dropdown.less -->
                                <?php if($current_employee->id_position == 2){ ?>
                                <a href="#" class="dropdown-toggle <?php //echo ($sum_request == 0 ? 'hide' : '')?>" data-toggle="dropdown">
                                  <i class="fa fa-bell-o fa-lg"></i>
                                  <span class="label label-warning" style="width: 50px;"><?php echo $sum_request ?></span>
                                </a>
                                <ul class="dropdown-menu" style="width: 350px;">
                                  <li style="border-bottom: 1px solid #f4f4f4;" class="header">คุณมี <?php echo $sum_request ?> การแจ้งเตือน</li>
                                  <li>
                                    <!-- inner menu: contains the actual data -->
                                    <div class="menu">
                                        <?php if($current_employee['id_department'] == "hr0001"):?>
                                      <li class="view-amendment">
                                        <a style="padding: 10px; border-bottom: 1px solid #f4f4f4;" href="<?php echo route('data_management.notification_request.get')?>">
                                          <i class="fa fa-users text-aqua"></i> รายการคำร้องขอเปลี่ยนแปลงข้อมูลส่วนตัว
                                          <span class="label label-warning"><?php echo $sum_request_change_data ?></span>
                                        </a>
                                      </li>
                                        <?php endif ?>

                                      <li class="view-time-stamp-request">
                                        <a style="padding: 10px; border-bottom: 1px solid #f4f4f4;" href="<?php echo route('time_stamp.time_stamp_request.get')?>">
                                          <i class="fa fa-clock-o text-aqua"></i> รายการคำร้องขอลงเวลาย้อนหลัง
                                        <span class="label label-warning"><?php echo $sum_request_time_stamp ?></span>
                                        </a>
                                      </li>

                                      <li class="view-request-leave">
                                        <a style="padding: 10px; border-bottom: 1px solid #f4f4f4;" href="<?php echo route('leave.leave_request.get');?>">
                                          <i class="fa fa-calendar-o text-aqua"></i> รายการคำร้องขอลา
                                          <span class="label label-warning"><?php echo $sum_request_leave ?></span>
                                        </a>
                                      </li>

                                      <?php if($current_employee['id_department'] == "hr0001"):?>
                                      <li class="view-request-create-evaluation">
                                        <a style="padding: 10px;" href="<?php echo route('evaluation.create_evaluations_request.get')?>">
                                          <i class="fa fa-clipboard text-aqua"></i>รายการขออนุมัติสร้างแบบประเมิน
                                          <span class="label label-warning"><?php echo $sum_confirm_create_evaluation ?></span>
                                        </a>
                                      </li>
                                      <?php endif ?>
                                    </div>
                                  </li>
                                </ul>
                                <?php } ?> <!-- End if id_position == 2 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </section>

            <script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>

            <!-- jQuery 3 -->
            <script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
            <!-- Bootstrap 3.3.7 -->
            <script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
            <!-- main function -->
            <script src="/resources/assets/js/main.js"></script>
        </body>
        </html>
<!-- data -->
<div id="logout-form" data-url="<?php echo route('logout.index.post') ?>"></div>
<?php echo csrf_field() ?>