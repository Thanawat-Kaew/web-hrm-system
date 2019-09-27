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


function showDialog(form,title, oldValue=''){
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
		 msg_close();
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
};


function addEmployee(form, title){
	msg_waiting();
	var count = 0;
	var oldValue = {};
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