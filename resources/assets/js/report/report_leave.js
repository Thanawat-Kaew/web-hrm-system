msg_waiting()

	$('.datepicker').datepicker({format: 'dd-mm-yyyy'});

	$('#myTable').dataTable();

	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});


	$('#btn-search').on('click', function(){
		msg_waiting();
		var department  	= $('#report-department').val();
		var start_date  	= $('#select_start_date').val();
		var end_date    	= $('#select_end_date').val();
		var leaves_type  	= $('#select_leaves_type').val()
		var leaves_format  	= $('#select_leaves_format').val();
		console.log("department  		="+department);
		console.log('start_date  		='+start_date);
		console.log('end_date    		='+end_date);
		console.log('leaves_type 		='+leaves_type);
		console.log('leaves_format    	='+leaves_format);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' 		: 'getFormLeavesWhenChangeDepartment',
				'department'	: department,
				'start_date'	: start_date,
				'end_date'  	: end_date,
				'leaves_type'	: leaves_type,
				'leaves_format'	: leaves_format
			},
			success:function(result){
				if(result.data !== ""){
					$('#data-leaves').html(result.data);
					msg_close();
				}
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	});