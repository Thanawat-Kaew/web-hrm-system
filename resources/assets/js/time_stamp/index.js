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

function showDialog(form,title){
	var box = bootbox.dialog({ 
		title: title,
		message: form,
		size: 'xlarge',
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

	box.on("shown.bs.modal", function() {
		$('.timepicker').timepicker({format: 'hh:ii'})
		$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'})
	});
};

$('.time-clock').on('click', '.time_stamp', function(){
	window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
});