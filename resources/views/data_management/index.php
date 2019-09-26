<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        พนักงาน | 
        <small> Employee</small>
        <div class="col-sm-3 col-xs-12 pull-right">
            <div class="input-group input-group-sm">
                <input id="text-search" type="text" class="form-control" placeholder="Filter...">
                <span class="input-group-btn">
                    <button id="btn-search-device" type="button" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
    </h1>
</section>
<section class="content">
    <div class="form-group">
        <div class="col-sm-3 col-xs-12 pull-right input-group-sm">
            <select class="form-control select2" style="width: 100%;">
                <option selected="selected">เลือกแผนก...</option>
                <option>แผนก 1</option>
                <option>แผนก 2</option>
                <option>แผนก 3</option>
            </select>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-xs-12 pull-right input-group-sm add-employee">
                <button type="button" class="btn btn-sm btn-success pull-right add-employee-form"><i class="fa fa-plus"></i> พนักงาน</button>
            </div>
        </div>
    </div>

    <h4 class="box-title">หัวหน้าแผนก</h4>
    <hr>
    <div class="box-body" id="group-employee">
        <div class="row">
            <div class="col-md-2 col-sm-2 ">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header">
                        <!-- /.widget-user-image -->
                        <div class="group-image" align="center" valign="center">
                            <img src="/resources/assets/theme/adminlte/dist/img/user8-128x128.jpg">
                        </div>
                        <div class="about-employee">
                            <p>รหัส  :<span> 5951001063</span></p>
                            <p>ชื่อ   :<span> ธนวัฒน์  แก้วล้อมวัง</span></p>
                        </div>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li class="manage-employee">
                                <a style="margin: 5px border: 1px; color : #F76608;">
                                    <center>
                                        <i class="fa fa-cog"></i> Manage Data
                                    </center>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="box-title">พนักงาน</h4>
        <hr>
        <div class="box-body">
            <div class="row" id="group-employee">
                <?php for ($i=1; $i < 13; $i++) { ?>
                    <div class="col-md-2 col-sm-2 ">
                        <div class="box box-widget widget-user-2">
                            <div class="widget-user-header">
                                <!-- /.widget-user-image -->
                                <div class="group-image" align="center" valign="center">
                                    <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg">
                                </div>
                                <div class="about-employee">
                                    <p>รหัส  :<span> 5951001063</span></p>
                                    <p>ชื่อ   :<span> ธนวัฒน์  แก้วล้อมวัง</span></p>
                                </div>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li class="manage-employee">
                                        <a style="margin: 5px border: 1px; color : #F76608;">
                                            <center>
                                                <i class="fa fa-cog"></i> Manage Data
                                            </center>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('data_manage.ajax_center.post')?>"></div>
<?php echo csrf_field()?>


<!-- <div class="modal-body modal-center">
    <div class="form-group">
        <button class="btn btn-block btn-outline-warning" href="#">
            <center>
                <i class="fa fa-pencil"></i> แก้ไขข้อมูล
            </center>
        </button>
        <button class="btn btn-block btn-outline-danger" href="#">
            <center>
                <i class="fa fa-trash"></i> ลบข้อมูล
            </center>
        </button>
    </div>
</div>
-->



<!-- <section class="content">
    <div class="container">
        <h3>เพิ่มพนักงาน <small>| Add Employee</small></h3>
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
                        <input class="form-control" type="text" value="" readonly placeholder="Auto Generate">
                    </div>
                    ชื่อ
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-user-secret"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="สมหมาย">
                    </div>
                    นามสกุล
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-user-secret"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="แสนดี">
                    </div>
                    ตำแหน่ง
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <select class="form-control select2" style="width: 100%;">
                            <option selected="selected">เลือกตำแหน่ง...</option>
                            <option>ตำแหน่ง 1</option>
                            <option>ตำแหน่ง 2</option>
                            <option>ตำแหน่ง 3</option>
                        </select>
                    </div>
                    แผนก
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-sitemap"></i>
                        </div>
                        <select class="form-control select2" style="width: 100%;">
                            <option selected="selected">เลือกแผนก...</option>
                            <option>แผนก 1</option>
                            <option>แผนก 2</option>
                            <option>แผนก 3</option>
                        </select>
                    </div>
                    อัตราเงินเดือน
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-money"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="15,000...">
                    </div>
                    การศึกษา
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder=" ปริญญาตรี...">
                    </div>
                    อายุ
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa  fa-circle-o"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="25...">
                    </div>
                    ที่อยู่
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="ยานนาวา สาทร กรุงเทพฯ">
                    </div>
                    อีเมล์
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <input class="form-control" type="text" value="" placeholder="email@example.com">
                    </div>
                    ตั้งรหัสผ่านเข้าสู่ระบบ
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <input class="form-control" style="border-color: red;" type="text" value="" placeholder="Password...">
                    </div>
                    ยืนยันรหัสผ่านอีกครั้ง
                    <div class="input-group name_user">
                        <div class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <input class="form-control" style="border-color: red;" type="text" value="" placeholder="Confirm Password...">
                    </div><br>

                    <div class="form-group text-center">
                        <a href="">
                            <button class="btn btn-info pull-center" type="submit">บันทึก</button>
                        </a>
                        <a href="">
                            <button class="btn btn-danger pull-center" type="submit">ยกเลิก</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
