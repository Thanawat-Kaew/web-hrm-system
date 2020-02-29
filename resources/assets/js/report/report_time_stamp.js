msg_waiting()
$(document).ready(function(){
	$('.datepicker').datepicker({format: 'dd-mm-yyyy'});
	$('#myTable').dataTable();


	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
		//alert($(this).val());
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});

	$('#btn-search').on('click', function(){
		msg_waiting();
		var department  = $('#report-department').val();
		var start_date  = $('#select_start_date').val();
		var end_date    = $('#select_end_date').val();
		var start_time  = $('#select_start_time').val()
		//alert(start_time);
		var end_time    = $('#select_end_time').val();
		console.log("department  ="+department);
		console.log('start_date  ='+start_date);
		console.log('end_date    ='+end_date);
		console.log('start_time  ='+start_time);
		console.log('end_time    ='+end_time);
		//console.log(department);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormTimestampWhenChangeDepartment',
				'department': department,
				'start_date': start_date,
				'end_date'  : end_date,
				'start_time': start_time,
				'end_time'  : end_time
			},
			success:function(result){
				if(result.data !== ""){
					//console.log(result.data);
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
