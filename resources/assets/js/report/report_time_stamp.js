msg_waiting()

//import {hello} from './index.js';
import {showDialog} from '../evaluation/check_count_evaluations_emp.js';

$(document).ready(function(){

	//console.log(hello(5));

	$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
	$('#myTable').dataTable();


	$('.timePicker1').on('click', function(){
		getTimePicker($(this));
		//alert($(this).val());
	});

	$('.timePicker2').on('click', function(){
		getTimePicker($(this));
	});

	$('.choice_department').change(function(){
		var name_department = $(this).val();
		$('.list_name_employee').empty().append('<option value="">กรุณาเลือกชื่อ...</option>');
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
			$('.list_name_employee').addClass('hide');
		}
	});

	$('#btn-search').on('click', function(){
		msg_waiting();
		var department  = $('#report-department').val();
		var start_date  = $('#select_start_date').val();
		var end_date    = $('#select_end_date').val();
		var start_time  = $('#select_start_time').val();
		var id_employee = $('#name_employee').val();
		var end_time    = $('#select_end_time').val();
		console.log("department  ="+department);
		console.log('start_date  ='+start_date);
		console.log('end_date    ='+end_date);
		console.log('start_time  ='+start_time);
		console.log('end_time    ='+end_time);

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
					$('.name_employee').on('click' , function(){
						msg_waiting();
						var id_employee = $(this).data('id');
						sendEmail(id_employee);
					})
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
		var start_time  = $('#select_start_time').val();
		var end_time    = $('#select_end_time').val();
		var id_employee = $('#name_employee').val();


		window.open('/pdf/generatePDF_time_stamp?department='+department+'&start_date='+start_date+'&end_date='+end_date+"&start_time="+start_time+"&end_time="+end_time+"&id_employee="+id_employee,'_blank');
	})

	//$('.name_employee').on('click' , function(){
	$('#myTable').on("click",'.name_employee',function(){
		msg_waiting();
		var id_employee = $(this).data('id');
		sendEmail(id_employee);
	})
})

function sendEmail(id_employee){
	msg_waiting();
	var id_employee = $(this).data('id');
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: $('#ajax-center-url').data('url'),
		data: {method : 'getFormEmail',
			'id_employee'    : id_employee
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>แบบฟอร์มการส่งอีเมล์ <small> | Form E-mail Sender</small><img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_gmail.jpg'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_email.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_hotmail.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_outlook.png'></h4>"
			showDialog(result.data,title);
		},
		error : function(errors){
			console.log(errors);
		}
	})
}
