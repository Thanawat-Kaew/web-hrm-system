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
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-6 hidden-md hidden-sm hidden-lg">
                <div class="lockscreen-wrapper">
                    <div class="text-center">
                        <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                        <h4>HUMAN RESOURCE MANAGEMENT SYSTEM
                        </h4>
                        <hr>
                        <h5>ระบบบริหารจัดการทรัพยากรบุคคล</h5>
                        <a href="">
                            <button class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</button>
                        </a>
                    </div>
                </div>
            </div>
            <?php if(Session::has('current_employee')) :  ?>
            <?php $cur_emp = Session::get('current_employee');
                // /*echo $cur_emp['id_employee']*/;
                //var_dump($cur_emp['id_department']);
            ?>
            <?php endif ?>
            <div class="col-md-6">
                <!-- Automatic element centering -->
                <div class="lockscreen-wrapper">
                    <div class="links">
                        <div class="col-sm-12 col-xs-12">
                            <?php if(\Session::has('current_menu')) :  ?>
                            <?php foreach(\Session::get('current_menu') as $menu ):?>
                                <div class="col-sm-6 col-xs-6">

                                    <!-- <?php //echo ($menu->name_th)?>
                                    <?php //echo ($menu->name_en)?> -->
                                    <!-- <?php echo $menu->route ?> -->
                                    <a href="<?php echo route ($menu->route)  ?>">
                                        <img class="image_menu" src="<?php echo 'resources/image/'.$menu->image ?>">
                                    </a>
                                </div>
                            <?php endforeach ?>
                            <?php endif ?>
                        </div>
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
    <!-- /.content -->

    <!-- jQuery 3 -->
    <script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
