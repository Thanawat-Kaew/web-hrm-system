$('.cancel').click(function(){
	Swal.fire({
		title: 'คุณแน่ใจหรือไม่ ?',
		text: "ที่จะยกเลิกการตั้งค่านี้ !",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		textSize: 20,
		cancelButtonText: 'ไม่ใช่',
		confirmButtonText: 'ใช่!'
	}).then((result) =>{
		if (result.value){
			window.location.href = "/admin/admin_main";
			msg_waiting()
		}
	})
})

$('.save').click(function(){
	Swal.fire({
		title: 'คุณเพิ่มรายการนี้เรียบร้อย',
		type: 'success',
		showCancelButton: false,
		confirmButtonText: 'ปิด'

	}).then((result) =>{
		if (result.value){
			window.location.href = "/admin/admin_main";
			msg_waiting()
		}
	})
})

$('.add-header').on('click', '.add-header-form', function(){
	msg_waiting();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: $('#ajax-center-url').data('url'),
		data: {method : 'getFormAddHeader'},
		success: function (result) {
			//console.log(result.current_department);
			var current_department = result.current_department;
			var title = "<h4 style='color: red;'>เพิ่มหัวหน้าแผนก <small> | Add Header</small></h4>"
			showDialog(result.data,title, current_department);
			$('.upload_image').click(function(){
				var form_data       = new FormData();
				var file_picture   	= $('#inputfilepicture').prop('files')[0];
				//console.log(file_picture);
				form_data.append('file_picture', file_picture);
				$("#targetLayer").empty();
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type : 'POST',
					cache       : false,
					contentType : false,
					processData : false,
					url  : $('#upload-image-url').data('url'),
					data : form_data,
					success:function(result){
						//console.log(result);
						//console.log(result.data);
						$("#targetLayer").html(result.data);
					},
					error : function(errors){
						msg_close();
						console.log(errors);
					}
				});
			});
		},
		error : function(errors)
		{
			console.log(errors);
		}
	});
});

$('#department').on('change', function(){ // dropdown เปลั้ยนแผนก
	msg_waiting();
	var department = $(this).val();
	//console.log(department);
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#ajax-center-url').data('url'),
		data : {
			'method' : 'getFormHeaderAndEmployeeWithDepartmentForAdmin',
			'department': department
		},
		success:function(result){
			if(result.data !== ""){
				$('#employee').html(result.data.form_emp);
				$('#header').html(result.data.form_head);
				msg_close();
			}
		},
		error : function(errors){
			msg_close();
			console.log(errors);
		}
	});
});

$('#header, #employee').on('click', '.manage-employee', function(){
		msg_waiting();
		var id 		= $(this).data('form_id');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method'   : 'getManageData',
			'employee_id' : id
		},
		success: function (result) {
			//console.log(result.current_department);
			var current_department = result.current_department;
			var box = bootbox.dialog({
				title: '<h4 style="text-align: center; font-size : 16px;"> จัดการข้อมูล | Data Management</h4>',
				message: result.data,
				size: 'xlarge',
				onEscape: true,
				backdrop: true
			})
			msg_close();
			box.on('shown.bs.modal', function(){
					// Form edit data employee
					$('.edit_data').on('click', function(event) {
						msg_waiting();
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
							type: 'POST',
							url: $('#ajax-center-url').data('url'),
							data: { 'method' : 'getFormEditHeaderAndEmployeeForAdmin',
							'id'     : id
						},
						success: function (result) {
							//console.log(current_department);
							var title = "<h4 style='color: red;'>แก้ไขข้อมูลหัวหน้าและพนักงาน<small> | Edit HeaderAndEmployee</small></h4>"
							showDialog(result.data,title,current_department);
							msg_close();
								//console.log(id);
								$('.upload_image').click(function(){
									var form_data       = new FormData();
									var file_picture   	= $('#inputfilepicture').prop('files')[0];
									//console.log(file_picture);
									form_data.append('file_picture', file_picture);
									$("#targetLayer").empty();
									$.ajax({
										headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
										type : 'POST',
										cache       : false,
										contentType : false,
										processData : false,
										url  : $('#upload-image-url').data('url'),
										data : form_data,
										success:function(result){
											//console.log(result);
											//console.log(result.data);
											$("#targetLayer").html(result.data);
										},
										error : function(errors){
											msg_close();
											console.log(errors);
										}
									});
								});
							},
							error : function(errors)
							{
								console.log(errors);
							}
						})

					});

					// Form view data employee
					$('.view_data').on('click', function(event) {
						msg_waiting();
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
							type: 'POST',
							url: $('#ajax-center-url').data('url'),
							data: {'method' : 'getDataPersonal',
							'id'    : id
						},
							success: function (result) {
								var title = "<h4 style='color: red;'>ข้อมูลพนักงาน <small> | Personal Data</small></h4>"
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
							},
							error : function(errors){
								console.log(errors);
							}
						})
					});

				$('.delete_data').on('click', function(event) {
					msg_waiting();

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
					}).then((result) =>{

						if (result.value)

						{
							postDelete(url);
						}
					})
				});
			});
		},
		error : function(errors)
		{
			console.log(errors);
		}
	})
})

function showDialog(form,title,current_department, oldValue='',not_match, errors=''){
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
					if (title == "<h4 style='color: red;'>เพิ่มหัวหน้าแผนก <small> | Add Header</small></h4>") {
						addHeader(form, title, current_department);
					}else if(title == "<h4 style='color: red;'>แก้ไขข้อมูลหัวหน้าและพนักงาน<small> | Edit HeaderAndEmployee</small></h4>"){
						editHeaderAndEmployee(form, title,current_department);
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

		$('.upload_image').click(function(){
			var form_data       = new FormData();
			var file_picture   	= $('#inputfilepicture').prop('files')[0];
			//console.log(file_picture);
			form_data.append('file_picture', file_picture);
			$("#targetLayer").empty();
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type : 'POST',
				cache       : false,
				contentType : false,
				processData : false,
				url  : $('#upload-image-url').data('url'),
				data : form_data,
				success:function(result){
					//console.log(result);
					//console.log(result.data);
					$("#targetLayer").html(result.data);
				},
				error : function(errors){
					msg_close();
					console.log(errors);
				}
			});
		});



		$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
		msg_close();
		$('body').addClass('modal-open'); //scroll mouse
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
		//console.log(not_match);
		if(not_match){
			$('#confirm_password-text-error').html("Please try password again").show();
		}else{
			$('#confirm_password-text-error').html("Please try password again").hide();
		}

		if(errors !== ""){
			console.log(errors);
			jQuery.each(errors, function(k, v){
				$('#'+k+'-text-error').html(v).show();
				//console.log(k);
			})
		}
	})
};

function addHeader(form, title, current_department){
	msg_waiting();
	var count 			 = 0;
	var oldValue 		 = {};
	var password         = $('#password').val();
	var confirm_password = $('#confirm_password').val();
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

	// check match password
	var not_match = true;
	if(password != confirm_password) {
		//alert("1");
		showDialog(form, title, current_department, oldValue,not_match);
	}else{
		if(count > 0) {
			var not_match = false;
			//console.log("addHeader = "+not_match);
			//alert("2");
			showDialog(form, title, current_department, oldValue,not_match);
		}else{
			if(password == confirm_password) {
				//alert("3");
				saveAddHeader(form, title, current_department, oldValue,not_match);
			}
		}
	}
}

function saveAddHeader(form, title, current_department, oldValue,not_match){
	var current_department = current_department;
	var form_data       = new FormData();
	//var id_employee     = $('#id_employee').val();
	var file_picture   	= $('#inputfilepicture').prop('files')[0];
	var department 		= $('#add-header-department').val();
	var position 		= $('#position').val();
	var fname 			= $('#fname').val();
	var lname 			= $('#lname').val();
	var email      		= $('#email').val();
	var password 		= $('#confirm_password').val();
	var address 		= $('#address').val();
	var gender 			= $('#gender').val();
	var tel 			= $('#tel').val();
	var date_of_birth 	= $('#date_of_birth').val();
	var education 		= $('#education').val();
	var salary 			= $('#salary').val();

	//form_data.append('id_employee', id_employee);
	form_data.append('file_picture', file_picture);
	form_data.append('department', department);
	form_data.append('position', position);
	form_data.append('fname', fname);
	form_data.append('lname', lname);
	form_data.append('email', email);
	form_data.append('password', password);
	form_data.append('address', address);
	form_data.append('gender', gender);
	form_data.append('date_of_birth', date_of_birth);
	form_data.append('tel', tel);
	form_data.append('education', education);
	form_data.append('salary', salary);

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		cache       : false,
		contentType : false,
		processData : false,
		url  : $('#add-header-url').data('url'),
		data : form_data,
		success: function(s){
			//console.log(response.status);
			var data_resp = jQuery.parseJSON(s);
			alert(data_resp.status);
			console.log(data_resp.status);
			if(data_resp.status == "ok"){
				/*Swal.fire(
				{
					title: 'คุณเพิ่มรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((response) =>{


				})*/
					window.location.reload();

				$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type : 'POST',
					url  : $('#ajax-center-url').data('url'),
					data : {
						'method' : 'getFormHeaderAndEmployeeWithDepartmentForAdmin',
						'department': current_department
					},
					success:function(result){
						if(result.data !== ""){
							$('#employee').html(result.data.form_emp);
							$('#header').html(result.data.form_head);
							msg_close();
						}
					},
					error : function(errors){
						msg_close();
						console.log(errors);
					}
				});

			}else if(data_resp.status == "failed_add"){
				console.log(data_resp.message)
				Swal.fire(
				{
					//result.message1, result.message2,'warning'
					title: "ไม่สามารถเพิ่มหัวหน้าแผนกนี้ได้เนื่องจากแผนกนี้มีหัวหน้าอยู่แล้ว",
					type: 'failed',
					showCancelButton: false,
					confirmButtonText: 'ปิด'
				});
			}else{
				console.log(data_resp.message)
				alert("email ซ้ำ");
				//showDialog(form, title, current_department,oldValue,not_match, response.message);
			}
		},
		error: function(error){
			//console.log(response);
			console.log(error);
			alert('Data not save');
			msg_close();
		}
	});
}

function editHeaderAndEmployee(form, title, current_department){ // แก้ไขตำแหน่งของหัวหน้าหรือหนักงาน
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
		showDialog(form, title, oldValue,not_match);
	}else{
		saveEditHeaderAndEmployee(oldValue, current_department);
	}
}

function saveEditHeaderAndEmployee(oldValue, current_department){
	var current_department = current_department;
	var form_data       = new FormData();
	var file_picture   	= $('#inputfilepicture').prop('files')[0];
	var	id_employee 	= $('#id_employee').val();
	var	department 		= $('#add-emp-department').val();
	var	position 		= $('#position').val();

	form_data.append('file_picture', file_picture);
	form_data.append('id_employee', id_employee);
	form_data.append('department', department);
	form_data.append('position', position);
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		cache       : false,
		contentType : false,
		processData : false,
		url  : $('#edit-header-and-employee-url').data('url'),
		data : form_data,/*{
			id_employee : $('#id_employee').val(),
			department 	: $('#add-emp-department').val(),
			position 	: $('#position').val(),
		},*/
		success: function(response){
			if(response.status == "failed"){
				Swal.fire(
				{
					//result.message1, result.message2,'warning'
					title: 'ไม่สามรถเปลี่ยนตำแหน่งเป็นหัวหน้าได้เนื่องจากมีหัวหน้าอยู่',
					type: 'failed',
					showCancelButton: false,
					confirmButtonText: 'ปิด'
				});
			}else{
				Swal.fire(
				{
					title: 'แก้ไขข้อมูลสำเร็จ',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((response) =>{

					window.location.reload();

				})


				$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type : 'POST',
					url  : $('#ajax-center-url').data('url'),
					data : {
						'method' : 'getFormHeaderAndEmployeeWithDepartmentForAdmin',
						'department': current_department
					},
					success:function(result){
						if(result.data !== ""){
							$('#employee').html(result.data.form_emp);
							$('#header').html(result.data.form_head);
							msg_close();
						}
					},
					error : function(errors){
						msg_close();
						console.log(errors);
					}
				});

			}
			console.log(response);
		},
		error: function(error){
			alert('Data not save edit employee');
			msg_close();
		}
	});
}

function postDelete(url){
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
