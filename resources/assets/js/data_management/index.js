$(function(){

	$('#header, #employee').on('click', '.manage-employee', function(){
		msg_waiting();
		var id = $(this).data('form_id');
		var position = $(this).data('form_position');
		var department = $(this).data('form_department');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method'   : 'getManageData',
			'position' : position,
			'department' : department
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
							data: {'method' : 'getFormEditEmployee',
							'id'    : id
						},
						success: function (result) {
							var title = "<h4 style='color: red;'>แก้ไขข้อมูลพนักงาน <small> | Edit Employee</small></h4>"
							showDialog(result.data,title);
								//console.log(id);
								msg_close();
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
								size: 'small',
								onEscape: true,
								backdrop: 'static',
								buttons: {
									fum: {
										label: 'ยกเลิก',
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
				showDialog(result.data,title)
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

function showDialog(form,title, oldValue='',not_match){
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
						editEmployee();
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
				saveAddEmployee(oldValue);
			}
		}
	}

}

function saveAddEmployee(oldValue){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#add-employee-url').data('url'),
		data : {
			department 	: $('#department').val(),
			position 	: $('#position').val(),
			fname 		: $('#fname').val(),
			lname 		: $('#lname').val(),
			email      	: $('#email').val(),
			password 	: $('#confirm_password').val(),
			address 	: $('#address').val(),
			gender 		: $('#gender').val(),
			tel 		: $('#tel').val(),
			age 		: $('#age').val(),
			education 	: $('#education').val(),
			salary 		: $('#salary').val(),
		},
		success: function(response){
			msg_success()
		},
		error: function(error){
			alert('Data not save');
			msg_close();
		}
	});
}

function editEmployee(){

}

