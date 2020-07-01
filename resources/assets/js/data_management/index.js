$(function(){
	$('.list_emp').on('click',function(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormDumpEmp'
			},
			success:function(result){
				var box = bootbox.dialog({
					title: '<h4 style="text-align: center; font-size : 16px;"> เลือกข้อมูลส่งออก <img src="/public/image/icon_pdf.png" class="pull-left" style="width:40px; height:40px;"></h4>',
					message: result.data,
					size: 'xlarge',
					onEscape: true,
					className: 'modal_list_emp',
					backdrop: true,
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
				box.on('shown.bs.modal', function(){
					$('#departments_pdf').on('change', function(event) {
						var id_department = $(this).val();
						if (id_department != '1') {
							window.open('/data_manage/dump_employee_pdf?id_department='+id_department,'_blank');

						}
					});
				});
			},
			error : function(errors){
				console.log(errors);
			}
		});
	})

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
			//console.log(result.one);
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
							data: { 'method' : 'getFormEditEmployee',
							'id'     : id
						},
						success: function (result) {
							var title = "<h4 style='color: red;'>แก้ไขข้อมูลพนักงาน <small> | Edit Employee</small>"+id+"</h4>"
							showDialog(result.data,title,current_department);
							msg_close();
							$('.upload_image').click(function(){
								var form_data       = new FormData();
								var file_picture   	= $('#inputfilepicture').prop('files')[0];
								//console.log(file_picture);
								//console.log(id);
								form_data.append('file_picture', file_picture);
								form_data.append('id', id);
								//$('.aaa').append().empty();
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
										console.log(result.data);
										$("#targetLayer").html(result.data);
										//$("#targetLayer").append('<img class="image-preview" src="/public/before_save_image/'+result.data+'" class="upload-preview" style="width: 120px; height: 120px;" >');
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
						// console.log(url)
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

	$('.add-employee').on('click', '.add-employee-form', function(){
		msg_waiting();
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormAddEmployee'},
			success: function (result) {
				var current_department = result.current_department;
				//console.log(current_department);
				var title = "<h4 style='color: red;'>เพิ่มพนักงาน <small> | Add Employee</small></h4>"
				showDialog(result.data,title,current_department);
				/*$('.upload_image').click(function(){
					//alert("55");
					var form_data       = new FormData();
					var file_picture   	= $('#inputfilepicture').prop('files')[0];
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
							//console.log(result.data);
							$("#targetLayer").html(result.data);
						},
						error : function(errors){
							msg_close();
							console.log(errors);
						}
					});
				});*/
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})

	$('#department').on('change', function(){
		msg_waiting();
		var department = $(this).val();
		// alert(department);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormEmployeeWithDepartment',
				'department': department
			},
			success:function(result){
				if(result.data !== ""){
					//console.log(result.data.form_emp);

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

	$('#text-search').keyup(function(){
		search_table($(this).val());
	});
});

function showDialog(form,title, current_department, oldValue='',not_match, errors=''){
	//console.log(one);
	//console.log(oldValue);
	//console.log(current_department);
	//console.log(errors);
	/*$('.upload_image').click(function(){
		alert("55");
	});*/
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
					if (title == "<h4 style='color: red;'>เพิ่มพนักงาน <small> | Add Employee</small></h4>") {
						addEmployee(form, title, current_department);
					}else{
						editEmployee(form, title, current_department);
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
	//console.log(confirm_password);
	box.on('shown.bs.modal', function(){



		$('.upload_image').click(function(){
								var form_data       = new FormData();
								var file_picture   	= $('#inputfilepicture').prop('files')[0];
								//var id_employee     = $('')
								//console.log(file_picture);
								//console.log(id);
								form_data.append('file_picture', file_picture);
								//form_data.append('id', id);
								//$('.aaa').append().empty();
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
										console.log(result.data);
										$("#targetLayer").html(result.data);
										//$("#targetLayer").append('<img class="image-preview" src="/public/before_save_image/'+result.data+'" class="upload-preview" style="width: 120px; height: 120px;" >');
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
			//console.log(oldValue);
			$.each(oldValue, function(key, value) {
				//console.log($('#'+key).val(value));
				/*var vvv = $('#'+key).val(value);
				if(vvv != ""){*/
					$('#'+key).val(value);
					if(value == "") {
						//console.log(key);
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				/*}else{
					if(value == "") {
						//console.log(key);
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				}*/
			});
		}
		//console.log(not_match);
		if(not_match){
			$('#confirm_password-text-error').html("Please try password again").show();
		}else{
			$('#confirm_password-text-error').html("Please try password again").hide();
		}

		if(errors !== ""){
			jQuery.each(errors, function(k, v){
				$('#'+k+'-text-error').html(v).show();
			})
		}
	})
};

function addEmployee(form, title, current_department){
	console.log(current_department);
	msg_waiting();
	//var current_department = current_department;
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

	/*$('.upload_image').click(function(){
		alert("55");
	});*/

	// check match password
	var not_match = true;
	if(password != confirm_password) {
		showDialog(form, title, current_department,oldValue,not_match);
	}else{
		if(count > 0) {
			var not_match = false;
			showDialog(form, title, current_department,oldValue,not_match);
		}else{
			if(password == confirm_password) {
				saveAddEmployee(form, title, current_department,oldValue,not_match);
			}
		}
	}
}

function saveAddEmployee(form, title, current_department,oldValue,not_match){
	var form_data = new FormData();

	var file_picture   	= $('#inputfilepicture').prop('files')[0];
	var department 		= $('#add-emp-department').val();
	var position 		= $('#position').val();
	var fname 			= $('#fname').val();
	var lname 			= $('#lname').val();
	var email      		= $('#email').val();
	var password 		= $('#confirm_password').val();
	var address 		= $('#address').val();
	var gender 			= $('#gender').val();
	var tel 			= $('#tel').val();
	var date_of_birth   = $('#date_of_birth').val();
	var education 		= $('#education').val();
	var salary 			= $('#salary').val();

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
		url  : $('#add-employee-url').data('url'),
		data : 		form_data,
		success: function(response){
			/*var data_resp = jQuery.parseJSON(response);
			//console.log(ata_resp)
			if(data_resp.status == "success"){*/
				Swal.fire(
				{
					title: 'คุณเพิ่มรายการนี้เรียบร้อย',
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
						'method' : 'getFormEmployeeWithDepartment',
						'department': current_department
					},
					success:function(result){
						if(result.data !== ""){
							//console.log(result.data.form_emp);
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
				//$('#employee').append(data_resp.data);
				//$('.dept'+department).append(data_resp.data);
			/*}else{
				showDialog(form, title, oldValue,not_match, data_resp.message);
			}*/
		},
		error: function(error){
			alert('Data not save');
			msg_close();
		}
	});
}

function editEmployee(form, title, current_department=''){
	msg_waiting();
	//console.log(one);
	var current_department = current_department;
	var count 			 = 0;
	var oldValue 		 = {};
	var password         = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	jQuery.each($('.required'),function(){
		var name = $(this).attr('id');
		//console.log(name);
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
		showDialog(form, title,  current_department, oldValue,not_match);
	}else{
		if(count > 0) {
			//console.log(name);
			var not_match = false;
			showDialog(form, title,  current_department, oldValue,not_match);
		}else{
			if(password == confirm_password) {
				saveEditEmployee(oldValue, current_department);
			}
		}
	}
}

function saveEditEmployee(oldValue, current_department=''){
	//console.log(current_department);
	var current_department  = current_department;
	var form_data       = new FormData();
	var id_employee     = $('#id_employee').val();
	var file_picture   	= $('#inputfilepicture').prop('files')[0];
	var department 		= $('#add-emp-department').val();
	var position 		= $('#position').val();
	var fname 			= $('#fname').val();
	var lname 			= $('#lname').val();
	var email      		= $('#email').val();
	var password 		= $('#confirm_password').val();
	var address 		= $('#address').val();
	var gender 			= $('#gender').val();
	var tel 			= $('#tel').val();
	var date_of_birth 			= $('#date_of_birth').val();
	var education 		= $('#education').val();
	var salary 			= $('#salary').val();

	form_data.append('id_employee', id_employee);
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
		url  : $('#edit-employee-url').data('url'),
		data : form_data,
		success: function(response){
			/*var data_resp = jQuery.parseJSON(response);
			//console.log(data_resp.name);
			if(data_resp.message){
				if(data_resp.position == 'header'){
					//console.log('header');
					$('.header_image'+id_employee).append().empty();
					$('.header_image'+id_employee).append('<img src="/public/image/'+data_resp.message+'?t='+'time()"  style="width: 120px; height: 120px;" >');
				}else if(data_resp.position == 'employee'){
					//console.log('employee');
					$('.employee_image'+id_employee).append().empty();
					$('.employee_image'+id_employee).append('<img src="/public/image/'+data_resp.message+'?t='+'time()"  style="width: 120px; height: 120px;" >');
				}
			}else{
				console.log("not change");
			}*/
			Swal.fire(
			{
				title: 'แก้ไขข้อมูลสำเร็จ',
				type: 'success',
				showCancelButton: false,
				confirmButtonText: 'ปิด'

			}).then((response) =>{

				window.location.reload();

				/*$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type : 'POST',
					url  : $('#ajax-center-url').data('url'),
					data : {
						'method' : 'getFormEmployeeWithDepartment',
						'department': one
					},
					success:function(result){
						if(result.data !== ""){
							//console.log(result.data.form_emp);
							$('#employee').html(result.data.form_emp);
							$('#header').html(result.data.form_head);
							msg_close();
						}
					},
					error : function(errors){
						msg_close();
						console.log(errors);
					}
				});*/

			})
			/*if(current_department == 0){
			//if(current_department){
				window.location.reload();
			}else{*/
				//window.location.reload();
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type : 'POST',
					url  : $('#ajax-center-url').data('url'),
					data : {
						'method' : 'getFormEmployeeWithDepartment',
						'department': current_department
					},
					success:function(result){
						if(result.data !== ""){
							//console.log(result.data.form_emp);
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
				//window.location.reload();
			//}
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