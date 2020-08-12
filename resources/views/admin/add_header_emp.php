<section class="content-header">
    <h1>
        เพิ่มหัวหน้าพนักงาน |
        <small> Add Header</small>
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
        <?php if(isset($dept)){?>
            <select class="form-control select2 " style="width: 100%; height: 45px; font-size: 18px; border-radius: 10px;" id="department" data-dependent="header">
                <?php foreach($department as $departments) : ?>
                    <option value="<?php echo $departments['id_department']?>" <?php echo (($departments['id_department'] == $dept) ? 'selected' : '') ?> > <?php echo $departments['name']?> </option>
                <?php endforeach ?>
            </select>
        <?php }else{ ?>
            <select class="form-control select2 " style="width: 100%;" id="department" data-dependent="header">
                    <option value="">กรุณาเลือกแผนก</option>
                    <?php foreach($department as $value):?>
                        <option value="<?php echo $value->id_department?>"><?php echo $value->name?></option>
                    <?php endforeach?>
            </select>
        <?php } ?>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-xs-12 pull-right input-group-sm add-header">
                <button type="button" class="btn btn-sm btn-success pull-right add-header-form"><i class="fa fa-plus"></i> เพิ่มหัวหน้าพนักงาน</button>
            </div>
        </div>
    </div>
        <h4 class="box-title show-data" style="margin-left: 5px;">หัวหน้าแผนก </h4>
    <hr>
    <div class="box-body show" id="group-employee">
        <div class="row" id="header">
        <?php if(isset($dept)){
            if(isset($header)){?>
                <div class="col-md-3 col-sm-2">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header">
                            <div class="group-image header_image<?php echo $header->id_employee?>" align="center" valign="center">
                            <?php if(!empty($header->image)){?> <!-- ถ้ามีรูป  -->
                                <img src="/public/image/<?php echo $header->image."?t=".time()?>" class="user-image img-circle" alt="User Image" style="width: 128px; height: 128px;">
                            <?php }else{?> <!-- ถ้าไม่มีรุป -->
                                <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                                <?php echo "ไม่มีรูป";?>
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
            <?php }else{?>
                <center><h4>Not Header</h4></center>
            <?php } ?>
        <?php } ?>
        </div>
        <h4 class="box-title">พนักงาน</h4>
        <hr>
        <div class="box-body show group-employee" id="group-employee">
            <div class="row" id="employee">
            <?php if(isset($dept)){?>
                <?php foreach($employee as $key => $value){ ?>
                    <?php if($value['id_position'] == 1) {?>
                        <div class="col-md-3 col-sm-2 ?>">
                            <div class="box box-widget widget-user-2">
                                <div class="widget-user-header">
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
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
    </div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('admin.ajax_center.post')?>"></div>
<div id="add-header-url" data-url="<?php echo route('admin.add_header.post')?>"></div>
<div id="edit-header-and-employee-url" data-url="<?php echo route('admin.edit_header_and_employee.post')?>"></div>
<div id="upload-image-url" data-url="<?php echo route('admin.upload_image.post')?>"></div>
<?php echo csrf_field()?>