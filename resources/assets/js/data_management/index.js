$(function(){

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
							showDialog(result.data,title);
							msg_close();
								//console.log(id);
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
				var title = "<h4 style='color: red;'>เพิ่มพนักงาน <small> | Add Employee</small></h4>"
				showDialog(result.data,title);
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

function showDialog(form,title, oldValue='',not_match, errors=''){
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
						addEmployee(form, title);
					}else{
						editEmployee(form, title);
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

function addEmployee(form, title){
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
		showDialog(form, title, oldValue,not_match);
	}else{
		if(count > 0) {
			showDialog(form, title, oldValue,not_match);
		}else{
			if(password == confirm_password) {
				saveAddEmployee(form, title, oldValue,not_match);
			}
		}
	}
}

function saveAddEmployee(form, title, oldValue,not_match){
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
	var age 			= $('#age').val();
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
	form_data.append('age', age);
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
			var data_resp = jQuery.parseJSON(response);
			if(data_resp.status == "success"){
				Swal.fire(
				{
					title: 'คุณเพิ่มรายการนี้เรียบร้อย',
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
		error: function(error){
			alert('Data not save');
			msg_close();
		}
	});
}

function editEmployee(form, title){
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
		showDialog(form, title, oldValue,not_match);
	}else{
		if(count > 0) {
			showDialog(form, title, oldValue,not_match);
		}else{
			if(password == confirm_password) {
				saveEditEmployee(oldValue);
			}
		}
	}
}

function saveEditEmployee(oldValue){
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
	var age 			= $('#age').val();
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
	form_data.append('age', age);
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

				Swal.fire(
				{
					title: 'แก้ไขข้อมูลสำเร็จ',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((response) =>{

					window.location.reload();

				})
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