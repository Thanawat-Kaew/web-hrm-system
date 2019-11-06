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
                        <a href="#" onClick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <button class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</button>
                        </a>
                        <form id="logout-form" action="<?php echo route('logout.index.post') ?>" method="POST" style="display: none;">
                            <?php echo csrf_field() ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="lockscreen-wrapper pull-left hidden-xs">
                        <div class="text-center" style="margin-top: 130px;">
                            <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                            <h4>HUMAN RESOURCE MANAGEMENT SYSTEM</h4>
                            <hr>
                            <h5>ระบบบริหารจัดการทรัพยากรบุคคล</h5>

                            <a href="#" onClick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <button class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</button>
                            </a>
                            <form id="logout-form" action="<?php echo route('logout.index.post') ?>" method="POST" style="display: none;">
                                <?php echo csrf_field() ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </section>
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>

       <!-- main function -->
<script src="/resources/assets/js/main.js"></script>
        <!-- jQuery 3 -->
        <script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
    </html>
