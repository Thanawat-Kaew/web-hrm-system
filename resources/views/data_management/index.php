<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        พนักงาน |
        <small> Employee</small>
        <div class="col-md-3 col-xs-12 pull-right hidden">
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
        <?php if(\Session::has('current_employee')) : ?>
            <?php $current_employee = \Session::get('current_employee') ?>
            <?php if($current_employee['id_department'] == "hr0001") : ?>
                <div class="col-sm-3 col-xs-12 pull-right input-group-sm">

                <?php if(isset($dept)){?>
                    <select class="form-control select2 " style="width: 100%; height: 45px; font-size: 18px; border-radius: 10px;" id="department" data-dependent="header">
                        <?php foreach($department as $departments) : ?>
                            <option value="<?php echo $departments['id_department']?>" <?php echo (($departments['id_department'] == $dept) ? 'selected' : '') ?> > <?php echo $departments['name']?> </option>
                        <?php endforeach ?>
                    </select>
                <?php }else{ ?>
                    <select class="form-control select2 " style="width: 100%; height: 45px; font-size: 18px; border-radius: 10px;" id="department" data-dependent="header">
                        <?php foreach($department as $departments) : ?>
                            <option value="<?php echo $departments['id_department']?>" <?php echo (($departments['id_department'] == $current_employee['id_department']) ? 'selected' : '') ?> > <?php echo $departments['name']?> </option>
                        <?php endforeach ?>
                    </select>
                <?php } ?>



                </div>
                <div class="form-group">
                    <div class="col-md-3 col-xs-12 pull-right add-employee">
                        <button type="button" class="btn btn-success pull-right add-employee-form"><i class="fa fa-plus"></i> พนักงาน</button>
                        <button type="button" class="btn btn-danger pull-right list_emp" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
    <h4 class="box-title show-data">หัวหน้าแผนก </h4>
    <hr>
    <div class="box-body show" id="group-employee">
        <div class="row" id="header">
            <div class="col-md-3 col-sm-2">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header">
                        <!-- /.widget-user-image -->
                        <div class="group-image header_image<?php echo $header->id_employee?>" align="center" valign="center">
                            <?php if(!empty($header->image)){?> <!-- ถ้ามีรูป  -->
                            <img src="/public/image/<?php echo $header->image."?t=".time()?>" class="user-image img-circle" alt="User Image" style="width: 128px; height: 128px;">
                            <?php /*echo "มีรูป";*/ ?>
                            <?php }else{?> <!-- ถ้าไม่มีรุป -->
                            <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                            <?php //echo "ไม่มีรูป";?>
                        <?php } ?>
                    </div>
                    <div class="about-employee">
                        <p id="header_id">รหัส  :<span><?php echo $header['id_employee']?></span></p>
                        <p id="header_name">ชื่อ   :<span><?php echo $header['first_name']?> <?php echo $header['last_name']?></span></p>
                    </div>

                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li class="manage-employee" data-form_id="<?php echo $header['id_employee']?>" data-form_position="<?php echo $header['id_position']?>" data-form_department="<?php echo $header['id_department']?>">
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
    <div class="box-body show group-employee" id="group-employee">
        <div class="row" id="employee">
            <?php //sd($employee->toArray())?>
            <?php foreach($employee as $key => $value): ?>
                <!-- <div class="dept<?php //echo $employee['id_department'] ?>"> -->
            <?php if($value['id_position'] == 1) : ?>
                    <div class="col-md-3 col-sm-2 ?>">
                        <div class="box box-widget widget-user-2">
                            <div class="widget-user-header">
                                <!-- /.widget-user-image -->
                                <div class="group-image employee_image<?php echo $value->id_employee?>" align="center" valign="center">
                                    <?php if(!empty($value->image)){?> <!-- ถ้ามีรูป  -->
                                    <img src="/public/image/<?php echo $value->image."?t=".time() ?>" class="user-image img-circle" alt="User Image" style="width: 120px; height: 120px;">
                                    <?php }else{?> <!-- ถ้าไม่มีรุป -->
                                    <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                                <?php } ?>
                            </div>
                            <div class="about-employee">
                                <p>รหัส  :<span><?php echo $value['id_employee']?></span></p>
                                <p>ชื่อ   :<span><?php echo $value['first_name']?> <?php echo $value['last_name']?></span></p>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li class="manage-employee" data-form_id="<?php echo $value['id_employee']?>" data-form_position="<?php echo $value['id_position']?>" data-form_department="<?php echo $value['id_department']?>">
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
        <!-- </div> -->
        <?php endforeach ?>
    </div>
</div>
</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('data_manage.ajax_center.post')?>"></div>
<div id="add-employee-url" data-url="<?php echo route('data_manage.add_employee.post')?>"></div>
<div id="edit-employee-url" data-url="<?php echo route('data_manage.edit_employee.post')?>"></div>
<div id="dump-employee-url" data-url="<?php echo route('data_manage.dump_emp.get')?>"></div>
<div id="dump-employee-url" data-url="<?php echo route('data_manage.dump_emp.post')?>"></div>
<div id="upload-image-url" data-url="<?php echo route('data_manage.upload_image.post')?>"></div>
<?php echo csrf_field()?>