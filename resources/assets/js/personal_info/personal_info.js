$(function(){
	$('.sidebar-toggle').hide();

		$('.amendment').click(function(){
			var	id = $(this).data('id');
			// alert(id);
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: 'POST',
				url: $('#ajax-center-url').data('url'),
				data: {'method' : 'getFormAmendmentEmployee',
				'id'	: id
			},
				success: function (result) {
				var title = "<h4 style='color: red;'>แจ้งแก้ไขข้อมูล <small> | Edit Employee</small></h4>"
				showDialog(result.data,title);
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})
});

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
	})
}

function sendRequest(form, title){
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
	}
}

function updateEmployee(){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#ajax-center-url').data('url'),
		data : {
			id          : $('#id').val(),
			fname 		: $('#fname').val(),
			lname 		: $('#lname').val(),
			position 	: $('#position').val(),
			department 	: $('#department').val(),
			education 	: $('#education').val(),
			gender 		: $('#gender').val(),
			age 		: $('#age').val(),
			address 	: $('#address').val(),
			email      	: $('#email').val(),
			tel 		: $('#tel').val(),
		},
		success: function(response){
			// success alert
			msg_success()
			// alert('Data save');
			// msg_close();
		},
		error: function(error){
			alert('Data not save');
			msg_close();
		}
	});
}