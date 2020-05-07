$(document).ready(function(){

	// $('.canvasjs-chart-credit').removeClass();
	$('.dsh_table_view').click(function(){
		$('#table_view').removeClass('hide');
		$('#box_view').addClass('hide');
	})

	$('.dsh_box_view').click(function(){
		$('#table_view').addClass('hide');
		$('#box_view').removeClass('hide');
	})

	$('#change_department').on('change', function(){
		// alert(department);
		msg_waiting();
		var department = $(this).val();

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' 		: 'getFormChangeDepartmentDashboard',
				'department'	: department
			},
			success:function(result){
				if(result.data !== ""){
					$('#form_total_emp').html(result.data.form_total_emp);
					$('#form_gender').html(result.data.form_gender);
					$('#form_age').html(result.data.form_age);
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