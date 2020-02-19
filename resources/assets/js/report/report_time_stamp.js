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
})
