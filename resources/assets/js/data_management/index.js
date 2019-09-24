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

function showDialog(form,title){
	bootbox.dialog({ 
		title: title,
		message: form,
		size: 'large',
		onEscape: true,
		backdrop: true,
		buttons: {
			fi: {
				label: 'บันทึก',
				className: 'btn-info',
				callback: function(){

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
};
