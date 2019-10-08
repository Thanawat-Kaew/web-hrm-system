$('.dropup').on('click', '.add-leave', function(){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
        type: 'POST',
        url: $('#ajax-center-url').data('url'),
        data: {method : 'getFormLeave'},
        success: function (result) {
            var title = "<h4 style='color: red;'>แบบฟอร์มลา <small> | Leave Form</small></h4>"
            showDialog(result.data,title)
        },
        error : function(errors)
        {
            console.log(errors);
        }
    })
})

function showDialog(form,title){
    var box = bootbox.dialog({ 
        title: title,
        message: form,
        size: 'large',
        onEscape: true,
        backdrop: 'static',
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

    box.on("shown.bs.modal", function() {
        // checkbox
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        // date time picker
        $(".form_datetime").datetimepicker({format: 'dd-mm-yyyy hh:ii'});
    });
};

// $('.dropup').on('click', '.add-leave', function(){
//     bootbox.dialog({ 
//         title: 'แบบฟอร์มลา | Leave Form',
//         message: '<div class="box-body">'+ 
//         'ประเภท'+
//         '<div class="input-group name_user">'+
//         '<div class="input-group-addon">'+
//         '<i class="fa fa-navicon"></i>'+
//         '</div>'+
//         '<select class="form-control select2" style="width: 100%;">'+
//         '<option selected="selected">เลือกประเภท...</option>'+
//         '<option>ลากิจส่วนตัว</option>'+
//         '<option>ลาป่วย</option>'+
//         '<option>ลาคลอดบุตร</option>'+
//         '<option>ลาไปช่วยเหลือภริยาหลังคลอด</option>'+
//         '<option>ลาพักผ่อน</option>'+
//         '<option>ลาอุปสมบท</option>'+
//         '<option>ลาไปประกอบพิธีฮัจญ์</option>'+
//         '<option>ลาเกี่ยวกับราชการทหาร</option>'+
//         '<option>ลาติดตามคู่สมรส</option>'+
//         '<option>การไปถือศีลปฏิบัติธรรม</option>'+
//         '</select>'+
//         '</div><br>'+
//         'รูปแบบ<br>'+
//         '<div class="form-group">'+
//         '<div class="col-sm-9">'+
//         '<label class="group-display">'+
//         '<input type="checkbox" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน'+
//         '</label>&nbsp&nbsp'+
//         '<label class="group-display">'+
//         '<input type="checkbox" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า'+
//         '</label>&nbsp&nbsp'+
//         '<label class="group-display"> '+
//         '<input type="checkbox" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย'+
//         '</label>&nbsp&nbsp'+
//         '</div>'+
//         '</div><br>'+
//         'ว/ด/ป'+
//         '<div class="form-group">'+ 
//         '<div class="input-group">'+
//         '<div class="input-group-addon">'+
//         '<i class="fa fa-calendar"></i>'+
//         '</div>'+
//         '<input type="text" name="daterangepicker" class="form-control pull-right" id="reservationtime">'+
//         '</div>'+
//         '</div><br>'+
//         'รวมจำนวน <i style="font-size: 30px; color: red"> 3 </i> วัน<br><hr>'+
//         'เหตุผลการลา<br>'+
//         '<textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Type..." rows="5"></textarea>',
//         size: 'large',
//         onEscape: true,
//         backdrop: true,
//         buttons: {
//             fi: {
//                 label: 'บันทึก',
//                 className: 'btn-info',
//                 callback: function(){

//                 }
//             },

//             fum: {
//                 label: 'ยกเลิก',
//                 className: 'btn-warning',
//                 callback: function(){

//                 }
//             }
//         }

//     })
//     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
//         checkboxClass: 'icheckbox_flat-green',
//         radioClass   : 'iradio_flat-green'
//     })
//     $('input[name="daterangepicker"]').daterangepicker({
//         timePicker: true,
//         startDate: moment().startOf('hour'),
//             // endDate: moment().startOf('hour').add(32, 'hour'),
//             locale: {
//                 format: 'M/DD hh:mm A'
//             }
//     })
// });







  // $('input[name="datetimes"]').daterangepicker({
  //   timePicker: true,
  //   startDate: moment().startOf('hour'),
  //   endDate: moment().startOf('hour').add(32, 'hour'),
  //   locale: {
  //     format: 'M/DD hh:mm A'
  //   }
  // });


    // bootbox.dialog({ 
    //     title: 'แบบฟอร์มลา | Leave Form',
    //     message: '',
    //     size: 'large',
    //     onEscape: true,
    //     backdrop: true,
    //     buttons: {
    //         fi: {
    //             label: 'บันทึก',
    //             className: 'btn-info',
    //             callback: function(){

    //             }
    //         },

    //         fum: {
    //             label: 'ยกเลิก',
    //             className: 'btn-warning',
    //             callback: function(){

    //             }
    //         }
    //     }

    // })
