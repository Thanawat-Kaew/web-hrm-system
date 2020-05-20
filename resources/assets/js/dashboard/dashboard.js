$(document).ready(function(){

	// $('.canvasjs-chart-credit').removeClass();
	$('.dsh_table_view').click(function(){
		Swal.fire({
			title: '',
			html: '<h4>Changed to Table-view</h4>',
			showConfirmButton: false,
			allowOutsideClick: false,
			customClass: 'swal-wide',
			timer: 1500,
		})

		$('#table_view').removeClass('hide');
		$('#box_view').addClass('hide');
		$('.dsh_table_view').addClass('hide');
		$('.dsh_box_view').removeClass('hide');
	})

	$('.dsh_box_view').click(function(){
		Swal.fire({
			title: '',
			html: '<h4>Changed to Box-view</h4>',
			showConfirmButton: false,
			allowOutsideClick: false,
			customClass: 'swal-wide',
			timer: 1500,
		})

		$('.dsh_box_view').addClass('hide');
		$('.dsh_table_view').removeClass('hide');

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
					$('#box_view').html(result.data.form_box_view);
					$('#table_view').html(result.data.form_table_view);
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