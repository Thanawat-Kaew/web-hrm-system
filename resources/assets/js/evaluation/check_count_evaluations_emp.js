$(document).ready(function() {
	msg_waiting()

	$('#topic_name').on('change', function(){ // dropdown เลือกหัวข้อการประเมิน
		msg_waiting();
		var id_topic = $(this).val();
		//console.log(id_topic);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormCheckCountEvaluationEmployee',
				'id_topic': id_topic
			},
			success:function(result){
				if(result.data !== ""){
					//console.log(result.data);
					//$('#employee').html(result.data.form_emp);
					//$('#header').html(result.data.form_head);

					$('#show_data').html(result.data.form);

					//console.log($('.show_data').html(result.data.form));
					//console.log("success");
					msg_close();
				}
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	})
});