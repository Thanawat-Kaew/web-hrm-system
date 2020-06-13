$(function(){
	msg_waiting()
	// $('.sidebar-toggle').hide();

	$('.amendment').click(function(){ // แก้ไข้ครั้งแรก
		msg_waiting()
		var	id = $(this).data('id');
		//alert("55");
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getFormAmendmentEmployee', /*ส่งไปที่ Employee Controller*/
			'id'	: id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>แจ้งแก้ไขข้อมูล <small> | Edit Employee</small></h4>"
			showDialog(result.data,title);
			msg_close();
		},
		error : function(errors)
		{
			console.log(errors);
		}
	})
	})

	$('.view-data').click(function(){
		msg_waiting()
		var	id = $(this).data('id');
		console.log(id)
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getHistoryChangeData',
			'id'	: id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>แก้ไขข้อมูล <small> | Edit Employee</small></h4>"
					// showDialog(result.data,title);
					bootbox.dialog({
						title: title,
						message: result.data,
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
					msg_close();
				},
				error : function(errors)
				{
					console.log(errors);
				}
			})
	})

	$('.send-email').click(function(){
		var id_employee = $(this).data('id');
		console.log(id_employee);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getFormEmail',
				'id_employee'    : id_employee
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แบบฟอร์มการส่งอีเมล์ <small> | Form E-mail Sender</small><img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_gmail.jpg'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_email.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_hotmail.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_outlook.png'></h4>"
				showDialog(result.data,title);
			},
			error : function(errors){
				console.log(errors);
			}
		})
	});

	$('.edit-data').click(function(){ // แก้ไข้ครั้งที่ 2
		msg_waiting()
		var	id = $(this).data('id');
		//console.log(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getEditAgain', /*ส่งไปที่ Employee Controller*/
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

	$('.delete-data').on("click", function()
	{
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

	});

});

function showDialog(form,title, oldValue=''){
	var box = bootbox.dialog({
		title: title,
		message: form,
		size: 'xlarge',
		onEscape: true,
		backdrop: 'static',
		buttons: {
			fi: {
				label: 'ส่งคำร้อง',
				className: 'btn-info',
				callback: function(){
					if(title == "<h4 style='color: red;'>แบบฟอร์มการส่งอีเมล์ <small> | Form E-mail Sender</small><img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_gmail.jpg'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_email.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_hotmail.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_outlook.png'></h4>"){
						formSendEmail(form, title);
					}else{
						sendRequest(form, title);
					}
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
		$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
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
		if(title == "<h4 style='color: red;'>แจ้งแก้ไขข้อมูล <small> | Edit Employee</small></h4>"){
			//alert("edit");
			editDataEmployee(oldValue);
		}else if(title == "<h4 style='color: red;'>แก้ไขข้อมูล <small> | Edit Employee</small></h4>"){
			//alert("update");
			updateEditDataEmployee(oldValue)
		}
	}
}

function editDataEmployee(oldValue){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#edit-data-employee').data('url'),
		data : {
			id_employee 	: $('#id_employee').val(),
			fname 			: $('#fname').val(),
			lname 			: $('#lname').val(),
			position 		: $('#position').val(),
			department 		: $('#department').val(),
			education 		: $('#education').val(),
			gender 			: $('#gender').val(),
			date_of_birth 	: $('#date_of_birth').val(),
			address 		: $('#address').val(),
			email      		: $('#email').val(),
			tel 			: $('#tel').val(),
			reason 			: $('#reason').val(),
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

function updateEditDataEmployee(oldValue){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#update-edit-data-employee').data('url'),
		data : {
			id          	: $('#id').val(),
			id_employee 	: $('#id_employee').val(),
			fname 			: $('#fname').val(),
			lname 			: $('#lname').val(),
			position 		: $('#position').val(),
			department 		: $('#department').val(),
			education 		: $('#education').val(),
			gender 			: $('#gender').val(),
			date_of_birth 	: $('#date_of_birth').val(),
			address 		: $('#address').val(),
			email      		: $('#email').val(),
			tel 			: $('#tel').val(),
			reason 			: $('#reason').val(),
		},
		success: function(response){
			// success alert
			msg_success()
			window.location.reload();
			// alert('Data save');
			// msg_close();
		},
		error: function(error){
			alert('Data not save for update');
			msg_close();
		}
	});
}

function postDelete(url)
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: "POST",
		url: url,
		success: function(result)
		{
			if(result.status == "success")
			{
				Swal.fire(
				{
					title: 'คุณลบรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((result) =>{

					if (result.value)
					{
						window.location.reload();
					}
				})

			}
			else
			{
				alert(result.message);
			}
		},
		error : function(errors)
		{
			console.log(errors);
		}
	});
}

function formSendEmail(form, title)
{
	var count     = 0;
	var oldValue  = {};
	//console.log(oldValue);
	jQuery.each($('.required'), function(){
		var name = $(this).attr('id');
		oldValue[name] = $(this).val();
		if($(this).val() == ""){
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
	});

	if(count > 0){
		showDialog(form, title, oldValue);
	}else{
		sendEmail(form, title);
	}
}

function sendEmail(form, title){
	Swal.fire({
		title: '<i class="fa fa-spinner fa-spin" style="font-size:30px"></i>',
		html: '<h3> กำลังส่ง รอสักครู่...</h3>',
		showConfirmButton: false,
		allowOutsideClick: false,
		customClass: 'swal-wide',
		timer: 5000,
	})

	var name_sender   = $('#name_sender').val();
	var email_sender  = $('#email_sender').val();
	var name_reciver  = $('#name_reciver').val();
	var email_reciver = $('#email_reciver').val();
	var topic         = $('#topic').val();
	var details       = $('#details').val();
	//alert(details);
	$.ajax({
		headers	: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type   	: 'POST',
		url    	: $('#send_email').data('url'),
		data 	: {
					'name_sender'   : name_sender,
					'email_sender'  : email_sender,
					'name_reciver'  : name_reciver,
					'email_reciver' : email_reciver,
					'topic'         : topic,
					'details'		: details
		},
		success: function (response) {
			msg_close();
			var data_resp = jQuery.parseJSON(response);
			console.log(data_resp);
			if(data_resp.status == "success"){
				Swal.fire(
				{
					title: 'คุณส่งอีเมล์นี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'
				}).then((response) =>{
					window.location.reload();
				})
			}else{
				showDialog(form, title, oldValue,not_match, data_resp.message);
			}
		},
		error : function(errors){
			alert("Don't send email");
			msg_close();
			//console.log(errors);
		}
	})
}

