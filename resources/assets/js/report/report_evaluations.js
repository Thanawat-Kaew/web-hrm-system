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

	$('#btn-search').on('click', function(){
		// alert("ok");
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

					$('#data-evaluation').html(result.data.form);
					msg_close();
				}
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
	});
});