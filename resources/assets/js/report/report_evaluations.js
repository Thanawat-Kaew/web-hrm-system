msg_waiting()
$(document).ready(function(){
	$('.datepicker').datepicker({format: 'dd-mm-yyyy'});

	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});

	$('#btn-search').on('click', function(){
		alert("ok");
		//msg_waiting();
		var department    = $('#report-department').val();
		var topic_name    = $('#report-topic-name').val();
		var start_date    = $('#select_start_date').val();
		var end_date      = $('#select_end_date').val();
		var start_number  = $('#start_number').val()
		var end_number    = $('#end_number').val();
		console.log("department  ="+department);
		console.log("topic_name  ="+topic_name);
		console.log('start_date  ='+start_date);
		console.log('end_date    ='+end_date);
		console.log('start_time  ='+start_number);
		console.log('end_time    ='+end_number);
		//console.log(department);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormEvaluationWhenChangeDepartment',
				'department'  : department,
				'topic_name'  : topic_name,
				'start_date'  : start_date,
				'end_date'    : end_date,
				'start_number': start_number,
				'end_number'  : end_number
			},
			success:function(result){
				if(result.data !== ""){
					//console.log(result.data);
					//$('#data-timestamp').html(result.data.form);
					msg_close();
				}
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	});
});