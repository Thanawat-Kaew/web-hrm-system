msg_waiting()
$(document).ready(function(){
	$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
	$('#myTable').dataTable();


	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
		//alert($(this).val());
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});


	$('.testemp').change(function(){
		var nnn = $(this).val();
		if(nnn != " "){
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type : 'POST',
				url  : $('#ajax-center-url').data('url'),
				data : {
					'method' : 'getFormNameEmployee',
					'department': nnn
				},
				success:function(result){
					if(result.data !== ""){
						$('#name_employee').removeClass('hide');
	    				var ip_serv = result.data;
	    				jQuery.each(ip_serv, function(k, v){
							var name    = v.first_name+" "+v.last_name;
							var id_name = v.id_employee;
							$('#name_employee').append('<option value="'+id_name+'">'+name+'</option>');
						});
					}
				},
				error : function(errors){
					msg_close();
					console.log(errors);
				}
			});
		}
	});


	$('#btn-search').on('click', function(){
		msg_waiting();
		var department  = $('#report-department').val();
		var start_date  = $('#select_start_date').val();
		var end_date    = $('#select_end_date').val();
		var start_time  = $('#select_start_time').val();
		var id_employee = $('#name_employee').val();
		//alert(start_time);
		//alert(name_employee);
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
				'end_time'  : end_time,
				'id_employee' : id_employee
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

	$('.genPDF_time_stamp').click(function(){
		var department  = $('#report-department').val();
		var start_date  = $('#select_start_date').val();
		var end_date    = $('#select_end_date').val();
		var start_time  = $('#select_start_time').val()
		var end_time    = $('#select_end_time').val();

		window.open('/pdf/generatePDF_time_stamp?department='+department+'&start_date='+start_date+'&end_date='+end_date+"&start_time="+start_time+"&end_time="+end_time,'_blank');
	})
})
