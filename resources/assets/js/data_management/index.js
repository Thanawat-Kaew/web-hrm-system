$('.add-employee').on('click', '.add-employee-form', function(){
    bootbox.dialog({ 
        title: ' เพิ่มพนักงาน | Add Employee',
        message: '<div class="row">'+
        '<div class="col-md-10" style="padding:0 15%;">'+
        '<div class="box-body">'+
        '<div class="profile-picture">'+
        '<div class="form-group">'+
        '<label for="exampleInputFile">Profile Picture</label>'+
        '<input type="file" id="exampleInputFile">'+
        '</div>'+
        '</div>'+
        'รหัสพนักงาน'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-key"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" readonly placeholder="Auto Generate">'+
        '</div>'+
        'ชื่อ'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-user-secret"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="สมหมาย">'+
        '</div>'+
        'นามสกุล'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-user-secret"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="แสนดี">'+
        '</div>'+
        'ตำแหน่ง'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-briefcase"></i>'+
        '</div>'+
        '<select class="form-control select2" style="width: 100%;">'+
        '<option selected="selected">เลือกตำแหน่ง...</option>'+
        '<option>ตำแหน่ง 1</option>'+
        '<option>ตำแหน่ง 2</option>'+
        '<option>ตำแหน่ง 3</option>'+
        '</select>'+
        '</div>'+
        'แผนก'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-sitemap"></i>'+
        '</div>'+
        '<select class="form-control select2" style="width: 100%;">'+
        '<option selected="selected">เลือกแผนก...</option>'+
        '<option>แผนก 1</option>'+
        '<option>แผนก 2</option>'+
        '<option>แผนก 3</option>'+
        '</select>'+
        '</div>'+
        'อัตราเงินเดือน'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-money"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="15,000...">'+
        '</div>'+
        'การศึกษา'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-graduation-cap"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder=" ปริญญาตรี...">'+
        '</div>'+
        'อายุ'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa  fa-circle-o"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="25...">'+
        '</div>'+
        'ที่อยู่'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-map-marker"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="ยานนาวา สาทร กรุงเทพฯ">'+
        '</div>'+
        'อีเมล์'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-envelope"></i>'+
        '</div>'+
        '<input class="form-control" type="text" value="" placeholder="email@example.com">'+
        '</div>'+
        'ตั้งรหัสผ่านเข้าสู่ระบบ'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-lock"></i>'+
        '</div>'+
        '<input class="form-control" style="border-color: red;" type="text" value="" placeholder="Password...">'+
        '</div>'+
        'ยืนยันรหัสผ่านอีกครั้ง'+
        '<div class="input-group name_user">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-lock"></i>'+
        '</div>'+
        '<input class="form-control" style="border-color: red;" type="text" value="" placeholder="Confirm Password...">'+
        '</div><br>'+
        '</div>'+
        '</div>'+
        '</div>',
        size: 'large',
        onEscape: true,
        backdrop: true,
        buttons: {
            fi: {
                label: 'บันทึก',
                className: 'btn-info',
                callback: function(){

                }
            },

            fum: {
                label: 'ยกเลิก',
                className: 'btn-warning',
                callback: function(){

                }
            }
        }
    })
});
