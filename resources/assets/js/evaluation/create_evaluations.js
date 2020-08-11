$(document).ready(function() {
	msg_waiting()
	var id_evaluation = $('#id-evaluation').data('value');
	$('.add-part').click(function(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormEvaluation',
				   id_evaluation  : id_evaluation},
			success: function (result) {
                $('#group-part').append(result.data);
            },
            error : function(error)
            {
            	console.log(error);
            }
        })
		// $("#group-part").on('click',".add-more", function(){
		// 	$(this).closest(".new-part").find(".selected-question").append($(".copy").html());
		// })
		// $("#group-part").on("click",".remove", function(){
		// 	$(this).parents('.control-group').remove();
		// })
	})

	$(".content").on('click', ".add-more", function(){

		var id_evaluation 	= $(this).closest(".panel-body").find("input[name=id_evaluation]").val();
		console.log(id_evaluation);
		var chapter 		= $(this).closest(".panel-body").find("input[name=chapter]").val();
		console.log(chapter);
		var id_part 		= $(this).closest(".panel-body").find("input[name=id_part-"+id_evaluation+"-"+chapter+"]").val();
		var total_question 	= parseInt($(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val());
		//console.log($(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val());
		var new_order_question 	= total_question+1;
		console.log("total_question="+new_order_question);
		$(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val(new_order_question);
		// $(this).closest(".new-part").find(".selected-question").append($(".copy").html());
		//alert("ok");

		$(this).closest(".new-part").find(".selected-question").append('<div class="group-question"><div class="control-group input-group" style="margin-top:10px">'+
			'<input type="text" name="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'[]" id="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'" class="form-control required" placeholder="คำถาม">'+
				'<div class="input-group-btn">'+
					'<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>'+
				'</div>'+
		'</div>'+
		'<label class="text-error name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'-text-error" id="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'-text-error"></label></div>');
	})

	/*$("#group-part").on('click',".btn-remove-part", function(){ // ลบตอน
		$(this).parents(".new-part").remove();
	})*/

	$(".content").on('click',".btn-remove-part", function(){ // ลบตอน
		var id = $(this).data('id');
		//console.log(id);
		$(this).parents(".new-part").remove();
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'deleteParts',
				   id  : id},
			success: function (result) {
                console.log(result);
            },
            error : function(error)
            {
            	console.log(error);
            }
		})
	})

	$(".content").on("click",".remove", function(){ // ลบคำถาม
		$(this).parents('.group-question').remove();
	})

	$('.btn-save').click(function(){
	 	sendData();
	});

	$('.btn-cancel').click(function(){
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่ ?',
			text: "ที่จะยกเลิกการสร้างแบบประเมิน !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			textSize: 20,
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่!'
		}).then((result) =>{
			if (result.value)
			{
				window.location.href = "/evaluation";
				msg_waiting()
			}
		})
	})

	$('.format-answer').click(function(){
		bootbox.alert({
			title: '<h4 style="text-align: center; font-size : 16px;"> รูปแบบคำตอบ</h4>',
			message: "<div class='' style='text-align:center;'><img style='width:300px; height:200px; border-radius:0px; border:red solid 1px;'"+
			"src='/resources/image/format_answer1.png'>รูปแบบที่ 1</div><br>"+
			"<div class='' style='text-align:center;'><img style='width:300px; height:200px; border-radius:0px;border:red solid 1px;'"+
			"src='/resources/image/format_answer2.png'>รูปแบบที่ 2</div>",
			size: 'auto',
		});
	})
})

function sendData(){
	msg_waiting();
	var count    		= 0;
	var oldValue 		= {};
	var check_percent  	= 0;
	jQuery.each($('.required'),function(){
		var name = $(this).attr('name');
		name = name.replace('[', "");
		name = name.replace(']', "");
		oldValue[name]= $(this).val();
		//console.log(name);
		if ($(this).val() =="") {
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
		//var c_p = $(this).closest('.panel-body').find('.percent').val();
	})
	//console.log(c_p);

	jQuery.each($('.percent'),function(){
		check_percent += parseInt($(this).val());
	});
	console.log(check_percent);

	if(check_percent > 100){
		Swal.fire('Fail', 'กรุณาอย่าใส่ค่า percent ของทุกตอนรวมกันไม่เกิน 100%','warning');
		if(count > 0) {
			if(oldValue !== ""){
				$.each(oldValue, function(key, value) {
					//console.log('#'+key+'-text-error');
					$('#'+key).val(value);
					if(value == "") {
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				});
			}

		}
	}else if(check_percent < 100){
		Swal.fire('Fail', 'กรุณาใส่ค่า percent ของทุกตอนรวมกันต้องเท่ากับ 100%','warning');
		if(count > 0) {
			if(oldValue !== ""){
				$.each(oldValue, function(key, value) {
					//console.log('#'+key+'-text-error');
					$('#'+key).val(value);
					if(value == "") {
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				});
			}

		}
	}else if(check_percent == 100){
		if(count > 0) {
			if(oldValue !== ""){
				$.each(oldValue, function(key, value) {
					//console.log('#'+key+'-text-error');
					$('#'+key).val(value);
					if(value == "") {
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				});
			}

		}else{

			document.getElementById("save-evaluation").submit();
		}
	}
}


























