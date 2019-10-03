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
            <select class="form-control select2" style="width: 100%;" id="department">
                <?php if(\Session::has('current_employee')) :
                       $current_employee = \Session::get('current_employee') ?>
                <?php foreach($department as $departments) : ?>
                    <option value="<?php echo $departments['id_department']?>" <?php echo ($departments['id_department'] == $current_employee['id_department']) ? 'selected' : '' ?> > <?php echo $departments['name']?> </option>
                <?php endforeach ?>
                <?php endif ?>
            </select>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-xs-12 pull-right input-group-sm add-employee">
                <button type="button" class="btn btn-sm btn-success pull-right add-employee-form"><i class="fa fa-plus"></i> พนักงาน</button>
            </div>
        </div>
    </div>

    <h4 class="box-title">หัวหน้าแผนก </h4>
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
                        <?php foreach($header as $key => $value):
                                if($value['id_position'] == 2) :
                        ?>
                        <div class="about-employee" id="header">
                            <p id="header_id">รหัส  :<span><?php echo $value['id_employee']?></span></p>
                            <p id="header_name">ชื่อ   :<span><?php echo $value['first_name']?> <?php echo $value['last_name']?></span></p>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
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

                    <!-- <?php/* for($i=0; $i<count($employee); $i++*/):?> -->
                <?php foreach($header as $key => $value):
                        if($value['id_position'] == 1) :
                    ?>
                    <div class="col-md-2 col-sm-2 ">
                        <div class="box box-widget widget-user-2">
                            <div class="widget-user-header">
                                <!-- /.widget-user-image -->
                                <div class="group-image" align="center" valign="center">
                                    <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg">
                                </div>
                                <div class="about-employee" id="employee">
                                    <p>รหัส  :<span><?php echo $value['id_employee']?></span></p>
                                    <p>ชื่อ   :<span><?php echo $value['first_name']?> <?php echo $value['last_name']?></span></p>
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
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('data_manage.ajax_center.post')?>"></div>
<div id="add-employee-url" data-url="<?php echo route('data_manage.add_employee.post')?>"></div>
<div id="change-department" data-url="<?php echo route('data_manage.change_department.post')?>"></div>
<?php echo csrf_field()?>