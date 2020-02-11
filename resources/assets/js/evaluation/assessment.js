$(document).ready(function() {
	msg_waiting()

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass   : 'iradio_flat-green'
	})

	$('.cancel_evaluation').click(function(){
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่ ?',
			text: "ที่จะยกเลิกการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			textSize: 20,
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่'
		}).then((result) =>{
			if (result.value)
			{
				window.location.href = "/evaluation/human_assessment";
			}
		})
	})


	var _sub_total 		= 0;
	var _part 			= "";
	$('.score').on('ifChecked', function(event){
		var _total_part			= 0;
		var checkd_name = $(this).attr('name');
		// var group_data = $(this).data('group');
		var part 			= $(this).data('part');
		var question 		= $(this).data('question');
		var total_question 	= $(this).closest('table').find('input[name=total-question]').val();
		var total_part 		= $(this).closest('table').find('input[name=total-part]').val();
		$("#total-question-"+part+"-"+question).html($(this).val());

		if (part != _part) {
			_part  = part;
			_sub_total  = 0;
		}

		for (var i=0; i < total_question; i++) {
			if( checkd_name == "format_answer-"+part+"-"+i) {
				var answer = parseInt($(this).val());
				_total_part = _total_part + answer;
				// _sub_total = _sub_total + answer;
			} else {
				var answer = $("input[name=format_answer-"+part+"-"+i+"]:checked").val();
				if(typeof(answer) !== "undefined") {
					_total_part = parseInt(_total_part) + parseInt(answer);
					// _sub_total = parseInt(_sub_total) + parseInt(answer);
				}
			}
		}
		$("#total-part-"+part).html(_total_part);
		var sum_total = 0;
		for (var j = 0; j < total_part; j++) {
			sum_total = sum_total+parseInt($("#total-part-"+j).html());
		}
		$("#total-evluation").html(sum_total);

	});



		//$('#part-total-'+parts).text($(this).val());
	/*$('input[data-part="'+parts+'"]:radio').on('ifChanged', function(event){
		alert("55");
		$('input:radio:checkbox').each(function(){
			theTotal += parseInt($(this).val());
		});
		$('#part-total-'+parts).text(theTotal);
	});*/

	//$('.total').text($(this).val());
});
