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
                           <h4>การศึกษา :  <?php echo $name_education['name'] ?> </h4>
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
                        <th>ครั้งที่ dgdgdgdgdgdgd</th>
                        <th>วันที่</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                        <th></th>
                    </tr>
                    <?php $count = 0; ?>
                    <?php foreach($request_edit_data as $value) : ?>
                        <?php $count = $count+1;?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $value['created_at'] ?></td>
                            <td>
                                <span class="label <?php echo ($value['status'] == 1 ? 'label-success' : ($value['status'] == 2 ? 'label-warning' : 'label-danger')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติแล้ว' : ($value['status'] == 2 ? 'กำลังรอ' : 'ไม่อนุมัติ')); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning form-control edit-data <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" data-id="<?php echo $value['id']?>">
                                <i class="fa fa-pencil btn <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" >
                                </i>
                            </button>
                            <button class="btn btn-danger form-control delete-data <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" data-id="<?php echo $value['id']?>" data-href="<?php echo route('personal_info.delete_employee.post',$value['id']);?>">
                                <i class="fa fa-trash btn <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" >
                                </i>
                            </button>
                        </td>
                        <td>
                            <i class="fa fa-eye fa-lg btn view-data" data-id="<?php echo $value['id']?>"></i>
                        </td>
                    </tr>
                <?php endforeach?>
            </table>
        </div>
    </div>
</div>

</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('personal_info.ajax_center.post')?>"></div>
<div id="edit-data-employee" data-url="<?php echo route('personal_info.edit_data_employee.post')?>"></div>
<div id="update-edit-data-employee" data-url="<?php echo route('personal_info.update_edit_data_employee.post')?>"></div>
<?php echo csrf_field()?>


