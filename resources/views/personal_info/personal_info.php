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

                        <div class="personal-data">
                            <h4>รหัสพนักงาน : <?php echo $current_id->id_employee ?> </h4>
                            <h4>ชื่อ - สกุล : <?php echo $current_id->first_name?> <?php echo $current_id->last_name?> </h4>
                            <h4>ตำแหน่ง : <?php echo $current_id->position->name ?> </h4>
                            <h4>แผนก : <?php echo $current_id->department->name ?> </h4>
                            <h4>อัตราเงินเดือน : <?php echo $current_id->salary ?> </h4>
                            <h4>การศึกษา : <?php echo $current_id->education ?> </h4>
                            <h4>เพศ : <?php echo $current_id->gender ?> </h4>
                            <h4>อายุ : <?php echo $current_id->age ?> </h4>
                            <h4>ที่อยู่ : <?php echo $current_id->address ?> </h4>
                            <h4>อีเมล์ : <?php echo $current_id->email ?> </h4>
                            <h4>เบอร์โทรศัพท์ : <?php echo $current_id->tel ?> </h4>
                        </div>
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
