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
		var start_number  = $('#start_number').val();
		var end_number    = $('#end_number').val();
		var id_employee   = $('#name_employee').val();

		window.open('/pdf/generatePDF_Eval?department='+department+'&topic_name='+topic_name+'&start_date='+start_date+"&end_date="+end_date+"&start_number="+start_number+"&end_number="+end_number+"&id_employee="+id_employee,'_blank');
	})

	//$('.view-evaluation').click(function(){
	$('#myTable').on("click",'.view-evaluation',function(){
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

	$('.data_visualization').on('click',function(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormDataVisualization'},
			success: function (result) {
				var title = "<h4 style='color: red;'>Data Visualization</h4>"
				showDialog(result.data,title)
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})

});

function showDialog(form,title,oldValue='',oldCheck='',errors=''){
	var box = bootbox.dialog({ 
		title: title,
		message: form,
		size: 'xlarge',
		onEscape: true,
		backdrop: 'static',
		buttons: {
			fi: {
				label: 'Go!',
				className: 'btn-info',
				callback: function(){
					sendRequest(form, title);
				}
			},
			fum: {
				label: 'Cancel',
				className: 'btn-warning',
				callback: function(){
				}
			}
		}   
	})

	box.on("shown.bs.modal", function() {

		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass   : 'iradio_flat-green'
		})

		$('#one_person').on('ifChecked', function(event){
			$('.one_person').removeClass('hide');
			$('.report_department').addClass('required');
			$('.list_name_employee ').addClass('required');
		}).on('ifUnchecked', function(event){
			$('.one_person').addClass('hide');
			$('.report_department').removeClass('required');
			$('.list_name_employee').removeClass('required');
		});

		// $('#one_department').on('ifChecked', function(event){
		// 	$('.one_department').removeClass('hide');
		// 	$('.report_department1').addClass('required');
		// 	$('.list_topic_evals').addClass('required');
		// }).on('ifUnchecked', function(event){
		// 	$('.one_department').addClass('hide');
		// 	$('.report_department1').removeClass('required');
		// 	$('.list_topic_evals').removeClass('required');

		// });

		$('#one_company').on('ifChecked', function(event){
			$('.one_company').removeClass('hide');
			$('.list_topic_evals2').addClass('required');

		}).on('ifUnchecked', function(event){
			$('.one_company').addClass('hide');
			$('.list_topic_evals2').removeClass('required');

		});

		$('body').addClass('modal-open');

		if(oldValue !== ""){
			$.each(oldValue, function(key, value) {
				$('#'+key).val(value);
				if(value == "") {
					$('#'+key + "-text-error").html("* Required").show();
				} else {
					$('#'+key + "-text-error").html("").hide();
				}
			});
		}

		if (oldCheck !== "") {
			$.each(oldCheck, function(key, value){
				if (value) {
					$('#'+key).iCheck('check');
					$('#edit-input-'+key).addClass('required');
				}else{
					$('#'+key).iCheck('uncheck')
					$('#edit-input-'+key).removeClass('required');
				}
			})
		}

		if(errors !== ""){
			jQuery.each(errors, function(k, v){
				$('#edit-input-'+k+'-text-error').html(v).show();
			})
		}

		$('.choice_department').change(function(){
			var get_name_emp = $(this).val();
			$('.name_employee').empty().append('<option value="">กรุณาเลือกชื่อ...</option>');

			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type : 'POST',
				url  : $('#ajax-center-url').data('url'),
				data : {
					'method' : 'getFormNameEmployee',
					'department': get_name_emp
				},
				success:function(result){
					if(result.data !== ""){
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
		});
	})
}

function sendRequest(form, title){
	msg_waiting();
	var select_format  		= $('input[name=format_visualization]:checked').val();
	var request_department1 = $('#report_department').val();
	var name_employee  		= $('#list_name_employee').val();
	var request_department2 = $('#report_department1').val();
	var list_topic_evals2 	= $('#list_topic_evals2').val();

	// if (request_department1 != "") {
	// 	if (name_employee == "") {
	// 		Swal.fire('ชื่อว่าง','กรุณาเลืกข้อมูลใหม่อีกครั้ง','warning');
	// 		$('.report_department').empty().append('<option value="">กรุณาเลือกแผนก...</option>');
	// 	}
	// }

    var count            = 0;
    var oldValue         = {};
    jQuery.each($('.required'),function(){
    	var name = $(this).attr('id');
    	oldValue[name]= $(this).val();
    	if ($(this).val() =="") {
    		count++
    		$(this).css({"border" : "1px solid red"});
    	} else {
    		$(this).css({"border" : "1px solid lightgray"});
    	}
    })

    var oldCheck = {};
    jQuery.each($('.flat-red'),function(){
    	var id = $(this).attr('id');
    	var checked = $(this).prop('checked');
    	oldCheck[id] = checked;

    })

    if(count > 0) {
    	showDialog(form, title, oldValue,oldCheck);
    } else {
    	requestDataVisualization(form, title, oldValue,select_format,request_department1,name_employee,request_department2,list_topic_evals2);
    }
}

function requestDataVisualization(form, title, oldValue,select_format,request_department1,name_employee,request_department2,list_topic_evals2){
	$.ajax({
		headers : {'X-CSRF-TOKEN': $('input[name=_token').attr('value')},
		type    : 'POST',
		url     : $('#request-data-visualization').data('url'),
		data    : {
			select_format      	: select_format,
			request_department1 : request_department1,
			name_employee      	: name_employee,
			request_department2	: request_department2,
			list_topic_evals2	: list_topic_evals2
		},
		success: function(result){
			if(result.status == "success"){
				var box = bootbox.dialog({
						title: '<h4 style="font-size : 16px;"> Data Visualizations</h4>',
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
				msg_close();
				box.on('shown.bs.modal', function(){
					
					
				})
			}

        },
        error: function(errors){
        	console.log(errors);
        },
    })
}

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