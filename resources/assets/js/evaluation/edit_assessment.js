$(document).ready(function() {
	msg_waiting()



	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass   : 'iradio_flat-green'
	})

	$('.cancel_evaluation').click(function(){
		var id_topic = $(this).closest('.col-md-9').find('input[name="id_topic"]').val();
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
				window.location.href = "/evaluation/human_assessment/"+id_topic;
			}
		})
	})


	var _sub_total 		= 0;
	var _part 			= "";
	$('.score').on('ifChecked', function(event){
		var _total_part			= 0;
		var checkd_name = $(this).attr('name'); // เป็นพวก ตอนที่เท่าไรคำถามที่เท่าไร เช่น format_answer-0-1, format_answer-0-2, format_answer-1-0
		//alert(checkd_name);
		// var group_data = $(this).data('group');
		var part 			= $(this).data('part'); // part ที่เท่าไร เช่น part ที่1 part ที่2

		//console.log(part);
		var question 		= $(this).data('question'); // question ที่เท่าไร เช่น question ที่1 question ที่2
		var total_question 	= $(this).closest('table').find('input[name=total-question]').val(); // การประเมินนี้มีกี่คำถาม
		//console.log(total_question);
		var total_part 		= $(this).closest('table').find('input[name=total-part]').val(); // การประเมินนี้มีกี่ตอน
		$("#total-question-"+part+"-"+question).html($(this).val()); // เอาคะแนนของแต่ละคำถามไปแสดง
		$("input[name=total-question-"+part+"-"+question+"]").val($(this).val());
		//console.log($("#total-question-"+part+"-"+question).html($(this).val()));

		if (part != _part) {
			_part  = part;
			_sub_total  = 0;
		}

		for (var i=0; i < total_question; i++) {
			if( checkd_name == "format_answer-"+part+"-"+i) {
				var answer = parseInt($(this).val()); //answer เก็บคะแนประเมินเมื่อกดเลือก เช่น กด เลือก 1 answer จะเก็บค่า 1
				//alert("1");
				_total_part = _total_part + answer;
				// _sub_total = _sub_total + answer;
			} else {
				var answer = $("input[name=format_answer-"+part+"-"+i+"]:checked").val();
				//alert("2");
				if(typeof(answer) !== "undefined") {
					_total_part = parseInt(_total_part) + parseInt(answer);
					// _sub_total = parseInt(_sub_total) + parseInt(answer);
				}
			}
		}
		$("#total-part-"+part).html(_total_part); //คะแนนของแต่ละตอนมาแสดง
		$("input[name=total-part-"+part+"]").val(_total_part); //เอาค่าคะแนนของแต่ละตอนไปใส่ใน value
		var sum_total = 0;
		for (var j = 0; j < total_part; j++) {
			sum_total = sum_total+parseInt($("#total-part-"+j).html());
		}
		$("#total-evluation").html(sum_total); //คะแนนของรวมของการประเมินนี้
		$("input[name=total-evluation]").val(sum_total); //เอาค่าคะแนนรวมของการประเมินนี้ใส่ใน value

	});

	$('.success_evaluation').click(function(){
		checkData();
	});
});

function checkData(){
	//msg_waiting();
	var count    = 0;
	var oldValue = {}; // object


	jQuery.each($('.required'),function(){
		var name = $(this).attr('name');
		//console.log("name="+name);
		name = name.replace('[', "");
		name = name.replace(']', "");
		oldValue[name]= $(this).val();
		//console.log(total_question);
		//console.log(oldValue[name]);
		if ($(this).val() == "") {
			count++
			$(this).css({"border" : "1px solid red"});
			//console.log("empty");
		}else{
			$(this).css({"border" : "1px solid lightgray"});
			//console.log("not empty");
		}
	})



	if(count > 0) {
		if(oldValue !== ""){
			$.each(oldValue, function(key, value) {
				//console.log('#'+key+'-text-error');
				//console.log(key);
				//console.log(value);
				/*$('#'+key).val(value);
				if(value == "") {
					$('#'+key + "-text-error").html("* Required").show();
					console.log(key);
				} else {
					$('#'+key + "-text-error").html("").hide();
				}*/
			});
			//alert("กรุณาใส่คะแนนให้ครบทุกช่อง");
			Swal.fire({
				title: 'คุณเพิ่มรายการนี้ไม่สำเร็จ',
				text: 'กรุณาใส่คะแนนให้ครบถ้วน',
				type: 'warning',
				showCancelButton: false,
				confirmButtonText: 'ปิด'
			})
		}
	}else{
		// alert("success");
		// document.getElementById("save-evaluation").submit();
		// var id_topic1 = $('#get_id_topic').val();
		// alert(id_topic1);

		// Swal.fire({
		// 	type: 'success',
		// 	title: 'Data has been saved',
		// 	showConfirmButton: false,
		// 	timer: 3000
		// }).then((result) => {
			document.getElementById("save-evaluation").submit();
			// window.location.href = "/evaluation/human_assessment/"/*+id_topic1*/;

		// })
	}
}
