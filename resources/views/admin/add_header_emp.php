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
                    <select class="form-control select2 " style="width: 100%;" id="department" data-dependent="header">
                            <option value="">กรุณาเลือกแผนก</option>
                            <?php foreach($department as $value):?>
                                <option value="<?php echo $value->id_department?>"><?php echo $value->name?></option>
                            <?php endforeach?>
                    </select>
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

        </div>

        <h4 class="box-title">พนักงาน</h4>
        <hr>
        <div class="box-body show group-employee" id="group-employee">
            <div class="row" id="employee">

            </div>
        </div>
    </div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('admin.ajax_center.post')?>"></div>
<div id="add-header-url" data-url="<?php echo route('admin.add_header.post')?>"></div>
<div id="edit-header-and-employee-url" data-url="<?php echo route('admin.edit_header_and_employee.post')?>"></div>
<div id="upload-image-url" data-url="<?php echo route('admin.upload_image.post')?>"></div>
<?php echo csrf_field()?>