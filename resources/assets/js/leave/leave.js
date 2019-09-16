$('.dropup').on('click', '.sick-form', function(){
    bootbox.dialog({ 
        title: 'แบบฟอร์มลาป่วย | Sick Form',
        message: '<div class="box-body">'+ 
        '<div class="form-group">'+
        '<div class="callout callout-info">'+
        '<h4>จำนวนวันลาคงเหลือ 7 วัน!</h4>'+
        '</div>'+
        '<label>จำนวนวันที่ลา <i style="font-size: 30px; color: red"> 3 </i> วัน</label><br><hr>'+
        '<label>ประเภท*</label><br>'+
        '<div class="form-group">'+
        '<div class="col-sm-9">'+
        '<label class="group-display">'+
        '<input type="checkbox" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน'+
        '</label>&nbsp&nbsp'+
        '<label class="group-display">'+
        '<input type="checkbox" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า'+
        '</label>&nbsp&nbsp'+
        '<label class="group-display"> '+
        '<input type="checkbox" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย'+
        '</label>&nbsp&nbsp'+
        '</div>'+
        '</div><br>'+
        '<div class="input-group">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-calendar"></i>'+
        '</div>'+
        '<input type="text" name="daterangepicker" class="form-control pull-right" id="daterangepicker">'+
        '</div><br>'+
        '<label>เหตุผลการลา</label><br>'+
        '<textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Enter..." rows="5"></textarea>',
        size: 'xlarge',
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
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    })
    $('input[name="daterangepicker"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
    })
});

$('.dropup').on('click', '.errand-form', function(){
    bootbox.dialog({ 
        title: 'แบบฟอร์มลากิจ | Errand Form',
        message: '<div class="box-body">'+ 
        '<div class="form-group">'+
        '<div class="callout callout-info">'+
        '<h4>จำนวนวันลาคงเหลือ 7 วัน!</h4>'+
        '</div>'+
        '<label>จำนวนวันที่ลา <i style="font-size: 30px; color: red"> 3 </i> วัน</label><br><hr>'+
        '<label>ประเภท*</label><br>'+
        '<div class="form-group">'+
        '<div class="col-sm-9">'+
        '<label class="group-display">'+
        '<input type="checkbox" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน'+
        '</label>&nbsp&nbsp'+
        '<label class="group-display">'+
        '<input type="checkbox" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า'+
        '</label>&nbsp&nbsp'+
        '<label class="group-display"> '+
        '<input type="checkbox" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย'+
        '</label>&nbsp&nbsp'+
        '</div>'+
        '</div><br>'+
        '<div class="input-group">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-calendar"></i>'+
        '</div>'+
        '<input type="text" name="daterangepicker" class="form-control pull-right" id="daterangepicker">'+
        '</div><br>'+
        '<label>เหตุผลการลา</label><br>'+
        '<textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Enter..." rows="5"></textarea>',
        size: 'xlarge',
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
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    })
    $('input[name="daterangepicker"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
    })
});




