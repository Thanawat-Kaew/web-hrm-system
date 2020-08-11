<section class="content-header">
    <div class="box-header">
        <h3>
            จัดการแผนก |
            <small> Department Manage</small>
        </h3>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="form-group">
                        <div class="box-header">
                            <h4>List of Departments.</h4>
                        </div>
                        <div class="col-md-12">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">NAME</th>
                                    </tr>
                                </thead>
                                <?php foreach ($department as $key => $value):?>
                                    <tbody>
                                        <tr>
                                            <th style="text-align: left; text-align:justify;" scope="row"><?php echo $value->id_department?></th>
                                            <td style="text-align: left;"><?php echo $value->name?></td>
                                        </tr>
                                    </tbody>
                                <?php endforeach?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h4>Put! Department</h4>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <input type="text" name="id_department" class="form-control get_id_department" style="border-radius: 5px;" placeholder="ระบุ ID Department...">
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="name_department" class="form-control get_name_department" style="border-radius: 5px;" placeholder="ระบุ Name Department...">
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <button class="pull-right btn btn-warning btn-cancel" style="margin-right: auto;">ยกเลิก</button>
                        <button class="pull-right btn btn-primary btn-save" style="margin-right: 5px;">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="add-department" data-url="<?php echo route('admin.get_add_department.post')?>"></div>
<?php echo csrf_field()?>