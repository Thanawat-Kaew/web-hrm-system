msg_waiting()
$(document).ready(function(){
	$('.datepicker').datepicker({format: 'dd-mm-yyyy'});
	$('#myTable').dataTable();


	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});

	$('#report-department').on('change', function(){
		msg_waiting();
		var department = $(this).val();
		console.log(department);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormTimestampWhenChangeDepartment',
				'department': department
			},
			success:function(result){
				if(result.data !== ""){
					console.log(result.data.form);
					$('#data-timestamp').html(result.data.form);
					msg_close();
				}
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	});
})
