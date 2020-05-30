msg_waiting()
$(document).ready(function(){
	$('.datepicker').datepicker({format: 'yyyy-mm-dd'});

	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});

	$('#myTable').dataTable();


	$('.choice_department').change(function(){
		var name_department = $(this).val();
		$('.list_name_employee').empty().append('<option value="">กรุณาเลือกชื่อ...</option>');
		//console.log(name_department);
		//$('.name_employee').empty();
		if(name_department != ""){
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type : 'POST',
				url  : $('#ajax-center-url').data('url'),
				data : {
					'method' : 'getFormNameEmployee',
					'department': name_department
				},
				success:function(result){
					if(result.data !== ""){
						$('.div_list_name_employee').removeClass('hide');
						$('.list_name_employee').removeClass('hide');
	    				var list_data = result.data;
	    				jQuery.each(list_data, function(k, v){
							var name    = v.first_name+" "+v.last_name;
							var id_name = v.id_employee;
							$('.list_name_employee').append('<option value="'+id_name+'">'+name+'</option>');
						});
					}
				},
				error : function(errors){
					msg_close();
					console.log(errors);
				}
			});
		}else if(name_department == ""){
			$('.div_list_name_employee').addClass('hide');
			$('.list_name_employee').addClass('hide');
		}
	});



	$('#btn-search').on('click', function(){
		// alert("ok");
		//msg_waiting();
		var department    = $('#report-department').val();
		var topic_name    = $('#report-topic-name').val();
		var id_employee   = $('#name_employee').val();
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
				'method'      : 'getFormEvaluationWhenChangeDepartment',
				'department'  : department,
				'topic_name'  : topic_name,
				'start_date'  : start_date,
				'end_date'    : end_date,
				'start_number': start_number,
				'end_number'  : end_number,
				'id_employee' : id_employee
			},
			success:function(result){
				if(result.data !== ""){
					//console.log(result.data);

					$('#data-evaluation').html(result.data.form);
					msg_close();
					//var id_employee = $(this).data('id');
					$('.view-evaluation').click(function(){
						var id_employee = $(this).data('id');
						var id_topic    = $(this).data('id_topic');
						viewEvaluation(id_employee, id_topic);
					})
				}
				//console.log(id_employee);
				//viewEvaluation(id_employee);
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	});

	$('.genPDF_evaluation').click(function(){
		var department    = $('#report-department').val();
		var topic_name    = $('#report-topic-name').val();
		var start_date    = $('#select_start_date').val();
		var end_date      = $('#select_end_date').val();
		var start_number  = $('#start_number').val()
		var end_number    = $('#end_number').val();

		window.open('/pdf/generatePDF_Eval?department='+department+'&topic_name='+topic_name+'&start_date='+start_date+"&end_date="+end_date+"&start_number="+start_number+"&end_number="+end_number,'_blank');
	})

	$('.view-evaluation').click(function(){
		msg_waiting();
		//alert('55');
		var id_employee     = $(this).data('id');
		//alert(id_employee);
		var id_topic 		= $(this).data('id_topic');
		//alert(id_topic);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' 	  : 'getViewEvaluation',
					'id_employee' : id_employee,
					'id_topic' 	  : id_topic
			},
			success: function (result){
				var title = "<h4 style='color: red;'>ดูลายละเอียดการประเมิน<small> | View Evaluation</small></h4>";
					bootbox.dialog({
						title: title,
						message: result.data,
						size: 'large',
						onEscape: true,
						backdrop: 'static',
						buttons: {
							fum: {
								label: 'ปิด',
								className: 'btn-warning',
								callback: function(){
								}
							}
						}
					})
					$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			            checkboxClass: 'icheckbox_flat-green',
			            radioClass   : 'iradio_flat-green checked'
			        })
					msg_close();
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	});
});

function viewEvaluation(id_employee, id_topic){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: $('#ajax-center-url').data('url'),
		data: {'method' 	  : 'getViewEvaluation',
				'id_employee' : id_employee,
				'id_topic' 	  : id_topic
		},
		success: function (result){
			var title = "<h4 style='color: red;'>ดูลายละเอียดการประเมิน<small> | View Evaluation</small></h4>";
				bootbox.dialog({
					title: title,
					message: result.data,
					size: 'xlarge',
					onEscape: true,
					backdrop: 'static',
					buttons: {
						fum: {
							label: 'ปิด',
							className: 'btn-warning',
							callback: function(){
							}
						}
					}
				})
				$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		            checkboxClass: 'icheckbox_flat-green',
		            radioClass   : 'iradio_flat-green checked'
		        })
				msg_close();
		},
		error : function(errors)
		{
			console.log(errors);
		}
	})
}