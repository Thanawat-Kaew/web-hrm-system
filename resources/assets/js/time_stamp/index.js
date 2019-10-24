$('.dropup-new-record').on('click', '.add-new-record', function(){
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

// ปุมลืมลงเวลาออก
$('.request-time_stamp').on('click', '.request_time_stamp', function(){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: $('#ajax-center-url').data('url'),
		data: {method : 'getRequestTimeStamp'},
		success: function (result) {
			var title = "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add Record (กรณีลืมลงเวลาออก)</small></h4>";
			showDialog(result.data,title)
		},
		error: function(errors){
			console.log(errors)
		}
	})
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
		$('.timepicker').timepicker(
		{
			format: 'HH:mm',
			use24hours: true,
			showMeridian: false
		})
		$('.datepicker').datepicker({autoclose: true,format: 'yyyy-mm-dd'})

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
	});
};

$('.time-clock').on('click', '.time_stamp', function(){
	window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
});

$('.timepicker').timepicker()
$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'})

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
		recordRequestTimeStamp(oldValue);
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
			alert('Data not save form edit');
			msg_close();
		}
	});
}

// $('.time-clock').on('click', '.time_stamp', function(){
// 	window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
// });