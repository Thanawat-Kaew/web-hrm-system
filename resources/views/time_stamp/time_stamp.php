<!DOCTYPE html>
<html>
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead downloading all them to reduce the load. -->
    <link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/skins/_all-skins.min.css">
    <!--Clock-->
    <link rel="stylesheet" href="/resources/assets/css/time_stamp/time_stamp.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">
        <section class="content">
            <h1>ลงเวลา</h1>
            <div class="row">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">TimeStamp</h3>
                    </div>
                    <div class="box-body">
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
                        <div class="input-group name_employee">
                            <div class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" ธนวัฒน์  แก้วล้อมวัง">
                        </div><br>
                        <div class="input-group password_employee">
                            <div class="input-group-addon">
                                <i class="fa fa-unlock"></i>
                            </div>
                            <input class="form-control" type="password" placeholder="Enter your password..." value="">
                        </div><br>
                        <div class="form-group ">
                            <label>รูปแบบ</label>
                            <select class="form-control select2" style="width: 100%;">
                                <option selected="selected" value="time_in77" id="time_in">ลงเวลาเข้า  (Time In)</option>
                                <option value="time_out"  id="time_out">ลงเวลาออก  (Time Out)</option>
                                <option value="break_out" id="break_out">ออกพักกลางวัน  (Break Out)</option>
                                <option value="break_in"  id="break_in">เข้าพักกลางวัน  (Break In)</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <a href="">
                                <button class="btn btn-info pull-center add_time_stamp" type="submit">SUBMIT</button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Time-In</th>
                            <th>Break-In</th>
                            <th>Break-Out</th>
                            <th>Time-Out</th>
                        </tr>
                        <tr>
                            <td>ธนวัฒน์ แก้วล้อมวัง</td>
                            <td>Web Developer</td>
                            <td>11-7-2014</td>
                            <td>09:00</td>
                            <td>-</td>
                            <td>-</td>
                            <td>18:00</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('time_stamp.add_time_stamp.post')?>"></div>


<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
<!--Clock-->
<script src="/resources/assets/js/time_stamp/time_stamp.js"></script>
</body>

</html>

