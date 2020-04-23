$(document).ready(function() {
	msg_waiting()

	// Filter Year.
	$('#myInput').keyup(function(){
		search_data_tbl();
	})

	$('.view-evaluation').click(function(){
		msg_waiting();
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
})

function search_data_tbl() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}