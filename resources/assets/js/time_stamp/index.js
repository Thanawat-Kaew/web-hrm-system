$(document).ready(function(){

	$('.dropup-new-record').on('click', '.add-new-record', function(){ // New Record
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormNewTimeClock'},
			success: function (result) {
				var title = "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add New Record</small></h4>";
				showDialog(result.data,title)
			},
			error: function(errors){
				console.log(errors)
			}
		})
	})

	


	$('.time-clock').on('click', '.time_stamp', function(){
		window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
	});

	$('.timepicker').timepicker()
	$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'})
})

function showDialog(form,title,oldValue=''){
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

		new Picker(document.querySelector('#time_in'), {
			format: 'HH:mm',
			headers:true,
		});

		new Picker(document.querySelector('#time_out'), {
			format: 'HH:mm',
			headers:true,
		});

		new Picker(document.querySelector('#break_in'), {
			format: 'HH:mm',
			headers:true,
		});

		new Picker(document.querySelector('#break_out'), {
			format: 'HH:mm',
			headers:true,
		});

		$('.datepicker').datepicker({autoclose: true,format: 'yyyy-mm-dd'})

		// Checkbox add new Record
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass   : 'iradio_flat-green'
		})

		$('#t_in_out').on('ifChecked', function(event){
			$('#t_in').iCheck('enable');
			$('#t_out').iCheck('enable');
		});

		$('#t_in_out').on('ifUnchecked', function(event){
			$('#t_in').iCheck('disable').iCheck('uncheck');
			$('#t_out').iCheck('disable').iCheck('uncheck');
		});

		$('#t_in').on('ifChecked', function(event){
			$('.time_in').removeClass('hide')
		}).on('ifUnchecked', function(event){
			$('.time_in').addClass('hide')
		});

		$('#t_out').on('ifChecked', function(event){
			$('.time_out').removeClass('hide')
		}).on('ifUnchecked', function(event){
			$('.time_out').addClass('hide')
		});

		$('#br_in_out').on('ifChecked', function(event){
			$('#br_in').iCheck('enable');
			$('#br_out').iCheck('enable');
		});

		$('#br_in_out').on('ifUnchecked', function(event){
			$('#br_in').iCheck('disable').iCheck('uncheck');
			$('#br_out').iCheck('disable').iCheck('uncheck');
		});

		$('#br_in').on('ifChecked', function(event){
			$('.break_in').removeClass('hide')
		}).on('ifUnchecked', function(event){
			$('.break_in').addClass('hide')
		});

		$('#br_out').on('ifChecked', function(event){
			$('.break_out').removeClass('hide')
		}).on('ifUnchecked', function(event){
			$('.break_out').addClass('hide')
		});
		// end Checkbox

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

		// ปุมลืมลงเวลาออก
		$('.forget_time_stamp').click(function(){
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: 'POST',
				url: $('#ajax-center-url').data('url'),
				data: {method : 'getRequestTimeStamp'},
				success: function (result) {
					var title = "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add Record (กรณีลืมลงเวลา)</small></h4>";
					showDialog(result.data,title)
				},
				error: function(errors){
					console.log(errors)
				}
			})
		})
	});
};


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
		//addRequestTimeStamp(oldValue);
		//alert("ok");
		if(title == "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add New Record</small></h4>"){
			//alert("Add New Record");
			addRequestTimeStamp(oldValue);
		}else if(title == "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add Record (กรณีลืมลงเวลา)</small></h4>"){
			//alert("Add Record");
			addRequestForgetToTime(oldValue);
		}
	}
}

function addRequestTimeStamp(oldValue){ // บันทึกลง Table Request_time_stamp
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#add-request-time-stamp').data('url'),
		data : {
			delay_time  : $('#date-history').val(),
			time_in 	: $('#time-in-history').val(),
			break_out 	: $('#break-out-history').val(),
			break_in 	: $('#break-in-history').val(),
			time_out 	: $('#time-out-history').val(),
			reason 	    : $('#reason-request-time-stamp').val(),
		},
		success: function(response){
			// success alert
			msg_success()
			window.location.reload();
			// alert('Data save');
			// msg_close();
		},
		error: function(error){
			alert('Data not save to request time stamp');
			msg_close();
		}
	});
}

function addRequestForgetToTime(oldValue){ // บันทึกลง Table request_forget_to_time
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#add-request-forget-to-time').data('url'),
		data : {
			type_time : $('#type-time-request-forget-to-time').val(),
			time     : $('#time-request-forget-to-time').val(),
			reason   : $('#reason-request-forget-to-time').val(),
			date     : $('#date-request-forget-to-time').val(),
		},
		success: function(response){
			// success alert
			msg_success()
			window.location.reload();
			// alert('Data save');
			// msg_close();
		},
		error: function(error){

			alert('Data not save to request forget to time');
			msg_close();
		}
	});
}

// $('.time-clock').on('click', '.time_stamp', function(){
// 	window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
// });

