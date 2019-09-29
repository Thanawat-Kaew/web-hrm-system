$(function(){
	$('#group-employee').on('click', '.manage-employee', function(){
		bootbox.dialog({
			title: '<h4 style="text-align: center; font-size : 16px;"> จัดการข้อมูล | Data Management</h4>',
			message: '    <div class="view-menu" style="padding:0 15%; text-align: center; font-size : 18px;">'+
			'<div class="form-group">'+
			'<button class="btn btn-block btn-info btn-outline-primary  href="#">'+
			'<center>'+
			'<i class="fa fa-search"></i> ดูข้อมูลส่วนตัว'+
			'</center>'+
			'</button>'+
			'<button class="btn btn-block btn-warning btn-outline-success" href="#">'+
			'<center>'+
			'<i class="fa fa-cog"></i> แก้ไขข้อมูล'+
			'</center>'+
			'</button>'+
			'<button class="btn btn-block btn-danger btn-outline-success" href="#">'+
			'<center>'+
			'<i class="fa fa-trash-o"></i> ลบข้อมูล'+
			'</center>'+
			'</button>'+
			'</ul>'+
			'</div>',
			size: 'xlarge',
			onEscape: true,
			backdrop: true,
		})
	});

	$('.add-employee').on('click', '.add-employee-form', function(){
		msg_waiting();
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormAddEmpolyee'},
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

});


function showDialog(form,title, oldValue='', not_match){
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
					addEmployee(form, title);
					//saveAddEmployee();
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
		$('body').addClass('modal-open'); //ถ้าไม่ใส่จะ scroll mouse ไม่ได้
		if(oldValue !== ""){  
			//console.log(oldValue); 
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
			$('#confirm_password-text-error').html("Password not match").show();
		}else{
			$('#confirm_password-text-error').html("Password not match").hide();
		}
	})
};


function addEmployee(form, title){
	msg_waiting();
	var count 			 = 0;
	var oldValue 		 = {}; // json
	var password         = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	jQuery.each($('.required'),function(){
		var name = $(this).attr('id'); // fname, lname
		//console.log(name); 
		oldValue[name]= $(this).val(); // 12, 11
		//console.log(oldValue[name]);
		//console.log(oldValue);
		if ($(this).val() =="") {
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
	})
	/*if(password != confirm_password){
		var not_match = true;
		if(count > 0) {
			showDialog(form, title, oldValue, not_match);
		}
		//saveAddEmployee(form);
	}else if(password == confirm_password){
		if(count > 0) {
			showDialog(form, title, oldValue);
		}
		//saveAddEmployee(form);
	}else{
		saveAddEmployee(form);
	}*/
	if(password != confirm_password){
		var not_match = true;
		if(count > 0) {
			showDialog(form, title, oldValue, not_match);
		}
		saveAddEmployee(oldValue);
	}else{
		if(count > 0) {
			showDialog(form, title, oldValue);
		}
		saveAddEmployee(oldValue);
	}

}

function saveAddEmployee(oldValue){
	//console.log(form)
	//console.log(oldValue[name]);
	//console.log(oldValue);
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
			console.log(response)
			alert('Data save');
		},
		error: function(error){
			//console.log(error)
			alert('Data not save');
		}
	});
}