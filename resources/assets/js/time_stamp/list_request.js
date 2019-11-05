$(document).ready(function(){
	$('.view-request-time-stamp').click(function(){
		msg_waiting()
		var	id = $(this).data('id');
		console.log(id)
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewDetailRequestTimeStamp',
					'id'	: id
			},
			success: function (result) {
			var title = "<h4 style='color: red;'>ดูลายละเอียดที่ขอลงเวลาย้อนหลัง</h4>"
					bootbox.dialog({
						title: title,
						message: result.data,
						size: 'large',
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
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})

	$('.edit-request-time-stamp').click(function(){ // แก้ไข้ที่ร้องขอไป
		msg_waiting()
		var	id = $(this).data('id');
		//console.log(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getEditRequestTimeStamp',
			'id'	: id
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูล <small> | Edit Employee</small></h4>"
				showDialog(result.data,title);
				msg_close();
			},
			error : function(errors){
				console.log(errors);
			}
		})
	})

	$('.view-request-forget-to-time').click(function(){
		msg_waiting()
		var	id = $(this).data('id');
		console.log(id)
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewDetailRequestForgetToTime',
					'id'	: id
			},
			success: function (result) {
			var title = "<h4 style='color: red;'>ดูลายละเอียดที่ขอลงเวลาย้อนหลัง ForgetToTime</h4>"
					bootbox.dialog({
						title: title,
						message: result.data,
						size: 'large',
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
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})

	$('.edit-request-time-stamp').click(function(){ // แก้ไข้ที่ร้องขอไป
		msg_waiting()
		var	id = $(this).data('id');
		//console.log(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getEditRequestTimeStamp',
			'id'	: id
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูล <small> | Edit Employee</small></h4>"
				showDialog(result.data,title);
				msg_close();
			},
			error : function(errors){
				console.log(errors);
			}
		})
	})
});

$('.timepicker').timepicker();
$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'});

function showDialog(form,title, oldValue=''){
	var box = bootbox.dialog({
		title: title,
		message: form,
		size: 'large',
		onEscape: true,
		backdrop: 'static',
		buttons: {
			fi: {
				label: 'ส่งคำร้อง',
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

	box.on('shown.bs.modal', function(){
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
		$('.timepicker').timepicker();
		$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'});
	})
}

function sendRequest(form, title){
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

	if(count > 0) {
		showDialog(form, title, oldValue);
	}else{
		updateEditRequestTimeStamp(oldValue);
	}
}

function updateEditRequestTimeStamp(oldValue){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#update-edit-request-timestamp').data('url'),
		data : {
			id        : $('#id-edit-reauest-time-stamp').val(),
			date      : $('#edit-date-request-time-stamp').val(),
			time_in   : $('#edit-time-in-request-time-stamp').val(),
			break_out : $('#edit-break-out-request-time-stamp').val(),
			break_in  : $('#edit-break-in-request-time-stamp').val(),
			time_out  : $('#edit-time-out-request-time-stamp').val(),
			reason    : $('#edit-reason-request-time-stamp').val(),
		},
		success: function(response){
			// success alert
			msg_success()
			//window.location.reload();
			// alert('Data save');
			// msg_close();
		},
		error: function(error){
			alert('Data not save for update rquest timestamp');
			msg_close();
		}
	});
}