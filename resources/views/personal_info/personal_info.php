<section class="content">
    <h3>ข้อมูลส่วนตัว <small>| Personal Information</small></h3>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                Name:<input type='email' name='name' class='name' style="text-transform: lowercase;" placeholder='Enter your name here'/>
                <div class="box-body">
                    <?php if(\Session::has('current_employee')) :?>
                        <?php $current_employee = \Session::get('current_employee') ?>

                        <div class="text-center">
                           <?php if(!empty($current_employee->image)){?> <!-- ถ้ามีรูป  -->
                                <img src="/public/image/<?php echo $current_employee->image ?>" class="user-image img-circle" alt="User Image" style="width: 160px; height: 160px;">
                            <?php }else{?> <!-- ถ้าไม่มีรุป -->
                                <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                            <?php } ?>
                        </div>

                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>รหัสพนักงาน</td>
                                        <td><?php echo $current_employee['id_employee'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ - สกุล</td>
                                        <td><?php echo $current_employee['first_name'] ?> <?php echo $current_employee['last_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>ตำแหน่ง</td>
                                        <td><?php echo $name_position['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>แผนก</td>
                                        <td><?php echo $name_department['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>อัตราเงินเดือน</td>
                                        <td><?php echo $current_employee['salary'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>การศึกษา</td>
                                        <td><?php echo $name_education['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>เพศ</td>
                                        <td><?php echo $current_employee['gender'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>อายุ</td>
                                        <td><?php echo $age ?> ปี</td>
                                    </tr>
                                    <tr>
                                        <td>ที่อยู่</td>
                                        <td><?php echo $current_employee['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>อีเมล์</td>
                                        <td><?php echo $current_employee['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>เบอร์โทรศัพท์</td>
                                        <td><?php echo $current_employee['tel'] ?></td>
                                    </tr>
                                </tbody></table>
                            </div>
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
                                <td>ครั้งที่</td>
                                <td>วันที่</td>
                                <td>สถานะ</td>
                                <td>แก้ไข</td>
                                <td></td>
                            </tr>
                            <?php $count = 0; ?>
                            <?php foreach($request_edit_data as $value) : ?>
                                <?php $count = $count+1;?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td class="created_at"><?php echo $value['created_at'] ?></td>
                                    <td>
                                        <span class="label <?php echo ($value['status'] == 1 ? 'label-success' : ($value['status'] == 2 ? 'label-warning' : 'label-danger')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติแล้ว' : ($value['status'] == 2 ? 'กำลังรอ' : 'ไม่อนุมัติ')); ?>
                                    </span>
                                </td>
                                <td>
                                    <i class="fa fa-pencil btn edit-data <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" data-id="<?php echo $value['id']?> <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" >
                                    </i>
                                    <i class="fa fa-trash btn delete-data <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" data-id="<?php echo $value['id']?>" data-href="<?php echo route('personal_info.delete_employee.post',$value['id']);?> <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 2 ? '' : 'hide')); ?>" >
                                    </i>
                                </td>
                                <td>
                                    <i class="fa fa-eye btn view-data" data-id="<?php echo $value['id']?>"></i>
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
<!-- get ใช้กับ ดึงข้อมูลมา ส่วน post ใช้กับ บันทึกข้อมูล -->
<?php echo csrf_field()?>


