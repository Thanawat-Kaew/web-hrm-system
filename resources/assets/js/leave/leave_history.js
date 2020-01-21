$(document).ready(function(){
    
	$('.view-request-leave').click(function(){
		var	id = $(this).data('id');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewRequestLeaves',
			'id'	: id
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูลการลา <small> | Edit Leave Request</small></h4>"
				bootbox.dialog({
					title: title,
					message: result.data,
					size: 'xlarg',
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
				msg_close();
				$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
					checkboxClass: 'icheckbox_flat-green',
					radioClass   : 'iradio_flat-green'
				})
			},
			error : function(errors){
				console.log(errors);
			}
		})
	})

	$('.delete-data').click(function(){
		var url=$(this).data('href');
		Swal.fire(
		{
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะลบรายการนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ลบ',
			confirmButtonText: 'ใช่, ลบเดี่ยวนี้!'
		}).then((result) => 
			{
				if (result.value) 

				{
					postDelete(url); 
				}
			})
	})

	$('.edit-data-request-leave').click(function(){
		var	id = $(this).data('id');

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getEditRequestLeaves',
			'id'    : id,
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูลการลา</h4>";
				showEditDialog(result.data,title)
			},
			error: function(errors){
				console.log(errors)
			}
		})
	})
})

function showEditDialog(form,title,oldValue='',oldCheck='',errors=''){

	var box = bootbox.dialog({
		title: title,
		message: form,
		size: 'xlarge',
		onEscape: true,
		backdrop: 'static',
		buttons: {
			fi: {
				label: 'บันทึก',
				className: 'btn-info',
				callback: function(){
					sendRequest(form, title);
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

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        $('#start_time_hour').on('click', function(){
                getTimePicker($(this));
        });

        $('#end_time_hour').on('click', function(){
                getTimePicker($(this));
        });

        // datepicker for leave full day
        $("#start_date_full").datepicker({format: 'yyyy-mm-dd'});
        $("#end_date_full").datepicker({format: 'yyyy-mm-dd'});
        $("#half_date").datepicker({format: 'yyyy-mm-dd'});
        $("#hour_date").datepicker({format: 'yyyy-mm-dd'});


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

		if(oldValue !== ""){
			$.each(oldValue, function(key, value) {
				$('#'+key).val(value);
				if(value == "") {
					$('#'+key + "-text-error").html("* Required").show();
				} else {
					$('#'+key + "-text-error").html("").hide();
				}
			});
		}

		if (oldCheck !== "") {
			$.each(oldCheck, function(key, value){
				if (value) {
					$('#'+key).iCheck('check');
					$('#edit-input-'+key).addClass('required');
				}else{
					$('#'+key).iCheck('uncheck')
					$('#edit-input-'+key).removeClass('required');
				}
			})
		}

		if(errors !== ""){
			jQuery.each(errors, function(k, v){
				$('#edit-input-'+k+'-text-error').html(v).show();
			})
		}
	});
};


function sendRequest(form, title,id){     

	msg_waiting();
	var count 			 = 0;
	var oldValue 		 = {};
	jQuery.each($('.required'),function(){
		var name = $(this).attr('id');
		oldValue[name]= $(this).val();
		if ($(this).val() =="") {
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
	})

	var oldCheck = {};
	jQuery.each($('.flat-red'),function(){
		var id = $(this).attr('id');
		var checked = $(this).prop('checked');
		oldCheck[id] = checked;

	})

	if(count > 0) {
		showEditDialog(form, title, oldValue,oldCheck);
	}else{
		editRequestLeave(form, title, oldValue,oldCheck,id);
	}
}

function editRequestLeave(form, title, oldValue,oldCheck){ // แก้ไข request_time_stamp
	 	var a = $("#start_date_full").datepicker('getDate');
        var b = $("#end_date_full").datepicker('getDate');
        var c = $("#half_date").datepicker('getDate');
        var d = $("#hour_date").datepicker('getDate');
        var e = parseInt($('#start_time_hour').val());
        var f = parseInt($('#end_time_hour').val());

        	// คำนวณ---------------------------ลาเต็มวัน
			var df_full 		= Math.ceil(((b - a)/1000/3600/24)+1);
            var val_df_full   	= Math.ceil((df_full)*8);
            // คำนวณ---------------------------ลาครึ่งวัน
            var df_half   		= Math.ceil(((c - c)/1000/3600/24)+1);
            var val_df_half 	= parseFloat((df_half - 0.5)*8);
            // คำนวณ---------------------------ลารายชั่วโมง
            var val_df_hour   	= Math.ceil(f - e);

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#edit-request-leave').data('url'),
		data : {
			id 							: $('#id_leave').val(),
			leave_type					: $('#id_leaves_type').val(),
			format_leave_three_time		: $('input[name=format_leaves]:checked').val(),
			format_range				: $('input[name=format_leave]:checked').val(),
			// -------------------------
			start_date_full				: $('#start_date_full').val(),
			end_date_full				: $('#end_date_full').val(),
			start_time_full				: $('#start_time_full').val(),
			end_time_full				: $('#end_time_full').val(),
			// -------------------------
			half_date					: $('#half_date').val(),
			start_time_morning			: $('#start_time_morning').val(),
			end_time_morning			: $('#end_time_morning').val(),
			start_time_afternoon		: $('#start_time_afternoon').val(),
			end_time_afternoon			: $('#end_time_afternoon').val(),
			// -------------------------
			hour_date					: $('#hour_date').val(),
			start_time_hour				: $('#start_time_hour').val(),
			end_time_hour				: $('#end_time_hour').val(),
			// -------------------------
			reason_leave				: $('#reason_leave').val(),
			approvers					: $('#id_approved').val(),
			// -------------------------
			val_df_full					: val_df_full,
			val_df_half					: val_df_half,
			val_df_hour					: val_df_hour,

		},
		success: function(response){

            var data_resp = jQuery.parseJSON(response);

            if(data_resp.status == "success"){
                Swal.fire({
                    title: 'บันทึกข้อมูลได้',
                    text: "",
                    type: 'success',
                })
            }else if(data_resp.status == "failed"){
                Swal.fire({
                    title: 'บันทึกข้อมูลไม่ได้',
                    text: 'กรุณาตรวจสอบข้อมูล',
                    type: 'error',
                })
            }
		},
		error: function(error){
			// alert('Edit data not save to request time stamp');
			// msg_close();
		}
	});
}


function postDelete(url)
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: "POST",
		url: url,
		success: function(result){
			if(result.status == "success"){
				Swal.fire(
				{
					title: 'คุณลบรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((result) =>{

					if (result.value){
						window.location.reload();
					}
				})
			} else {
				alert(result.message);
			}
		},	
		error : function(errors){
			console.log(errors);
		}
	});
}