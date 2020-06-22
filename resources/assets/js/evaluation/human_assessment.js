$(document).ready(function() {
	msg_waiting()

	$(".alert").delay(3000).slideUp(300, function() {
    	$(this).alert('close');
	});

	$('#myTable').dataTable({
		stateSave : true
	});

	// $('#myTable').on('click','.view-evaluation',function(){
	$('.view-evaluation').click(function(){
		msg_waiting();
		// alert('555');
		var id_employee = $(this).data('id');
		var id_topic    = $(this).data('id_topic');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' 		: 'viewEvaluation',
					'id_employee'	: id_employee,
					'id_topic' 	 	: id_topic
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
})