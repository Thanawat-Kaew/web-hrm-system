$(document).ready(function(){

    $('.view-data-request-leaves').click(function(){

		msg_waiting()
		var	id = $(this).data('id');

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewDataRequestLeaves',
			'id'	    : id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>ข้อมูลการลา <small> |  Data Leaves</small></h4>"
			showDialog(result.data,title)
				
			},
			error : function(errors){
				console.log(errors);
			}
		})
    });

    $('.btn-confirm-data-request-leave').click(function(){  //อนุมัติ

        var id = $(this).data('id');

        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "ที่จะอนุมัติการลานี้ !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ไม่ใช่',
            confirmButtonText: 'ใช่, อนุมัติ!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
                    type: "POST",
                    url: $('#confirm-data-request-leave').data('url'),
                    data: {'id'     : id
                    }
                });
            Swal.fire(
                'อนุมัติ!',
                'คุณได้ทำการอนุมัติเรียบร้อย',
                'success').then((result) =>{
                    if (result.value){
                        window.location.reload();
                    }
                })
            }
        })
    })

    $('.btn-cancel-data-request-leave').click(function(){  // ปฏิเสธ

        var id = $(this).data('id');

        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "ที่จะไม่อนุมัติการลานี้ !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ไม่ใช่',
            confirmButtonText: 'ใช่, ไม่อนุมัติ!'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'กรุณากรอกเหตุผล',
                    input: 'textarea',
                    inputPlaceholder: 'Type your message here...',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true
                }).then((result) => {
                    if(result.value !== ''){
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
                            type: "POST",
                            url: $('#cancel-data-request-leave').data('url'),
                            data:{'id'             : id,
                                   'reason_reject' : result.value
                            }
                    });
                    Swal.fire(
                        'สำเร็จ!',
                        'คุณได้ปฏิเสธการ้องขอเรียบร้อย',
                        'success'
                        ).then((result) =>{
                            if (result.value){
                                window.location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'ไม่สำเร็จ!',
                            'กรุณากรอกเหตุผล สำหรับการไม่อนุมัติในครั้งนี้',
                            'warning')
                    }
                })
            }
        })
    })
})

function showDialog(form,title,oldValue='',oldCheck='',errors=''){

    var box = bootbox.dialog({ 

        title: title,
        message: form,
        size: 'xlarge',
        onEscape: true,
        backdrop: 'static',
        buttons: {
            fum: {
                label: 'ปิด',
                className: 'btn-warning',
                callback: function(){
                }
            }
        }
    })

    box.on("shown.bs.modal", function() {

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        $('#start_time_h_a').on('click', function(){
                getTimePicker($(this));
        });

        $('#end_time_h_a').on('click', function(){
                getTimePicker($(this));
        });

        $(".form_datetime").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime1").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime2").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime3").datepicker({format: 'yyyy-mm-dd'});

        $('.full_day').on('ifChecked', function(event){
            $('.full_day_leave').removeClass('hide');
            $('.form_datetime').addClass('required');
            $('.form_datetime1').addClass('required');
            $('.half_morning_leave').addClass('hide');
            $('.half_afternoon_leave').addClass('hide');
            $('.total_num').removeClass('hide');
        }).on('ifUnchecked', function(event){
            $('.full_day_leave').addClass('hide');
            $('.form_datetime').removeClass('required');
            $('.form_datetime1').removeClass('required')});

        $('.half').on('ifChecked', function(event){
            $('.half_morning_leave').removeClass('hide');
            $('.form_datetime2').addClass('required');
            $('.full_day_leave').addClass('hide');
            $('.half_afternoon_leave').addClass('hide');
            $('.total_num').addClass('hide');
        }).on('ifUnchecked', function(event){
            $('.half_morning_leave').addClass('hide');
            $('.form_datetime2').removeClass('required')});

        $('.hour').on('ifChecked', function(event){
            $('.half_afternoon_leave').removeClass('hide');
            $('.form_datetime3').addClass('required');
            $('.full_day_leave').addClass('hide');
            $('.half_morning_leave').addClass('hide');
            $('.total_num').addClass('hide');
        }).on('ifUnchecked', function(event){
            $('.half_afternoon_leave').addClass('hide');
            $('.form_datetime3').removeClass('required')});

        $('body').addClass('modal-open');
    })
}