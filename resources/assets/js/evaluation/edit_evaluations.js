$(document).ready(function(){

	msg_waiting()
	var id_evaluation = $('#id-evaluation').data('value'); // เพิ่มตอน
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

	$(".content").on('click', ".add-more", function(){  // เพิ่มคำถาม

		var id_evaluation 	= $(this).closest(".panel-body").find("input[name=id_evaluation]").val();
		console.log("id_evaluation="+id_evaluation);
		var chapter 		= $(this).closest(".panel-body").find("input[name=chapter]").val();
		console.log("chapter="+chapter);
		var id_part 		= $(this).closest(".panel-body").find("input[name=id_part-"+id_evaluation+"-"+chapter+"]").val();
		//console.log("id_part="+id_part);
		var total_question 	= parseInt($(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val());
		//console.log("total_question="+total_question);
		//console.log($(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val());
		var new_order_question 	= total_question+1;
		console.log("total_question="+new_order_question);

		$(this).closest(".panel-body").find("input[name=total-question-"+id_evaluation+"-"+chapter+"]").val(new_order_question);


		// $(this).closest(".new-part").find(".selected-question").append($(".copy").html());
		//alert("ok");

		$(this).closest(".new-part").find(".selected-question").append('<div class="control-group input-group" style="margin-top:10px">'+
			'<input type="text" name="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'[]" id="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'" class="form-control required" placeholder="คำถาม">'+
				'<div class="input-group-btn">'+
					'<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>'+
				'</div>'+
		'</div>'+
		'<label class="text-error name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'-text-error" id="name-question-'+id_evaluation+"-"+chapter+"-"+ new_order_question +'-text-error"></label>');
	})

	$(".content").on('click',".btn-remove-part", function(){ // ลบตอน
		$(this).parents(".new-part").remove();
		//alert("ok");
	});

	$(".content").on("click",".remove", function(){ // ลบคำถาม
		var id = $(this).data('id');
		$(this).parents('.control-group').remove();
		//console.log(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'deleteQuestion',
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

	$('.format-answer').click(function(){  // รูปแบบการประเมิน
		bootbox.alert({
			title: '<h4 style="text-align: center; font-size : 16px;"> รูปแบบคำตอบ</h4>',
			message: "<div class='' style='text-align:center;'><img style='width:300px; height:200px; border-radius:0px; border:red solid 1px;'"+
			"src='/resources/image/format_answer1.png'>รูปแบบที่ 1</div><br>"+
			"<div class='' style='text-align:center;'><img style='width:300px; height:200px; border-radius:0px;border:red solid 1px;'"+
			"src='/resources/image/format_answer2.png'>รูปแบบที่ 2</div>",
			size: 'auto',
		});
	})

	$('.btn-save').click(function(){
	 	sendData();
	});


});

function sendData(){
	msg_waiting();
	var count    = 0;
	var oldValue = {};
	jQuery.each($('.required'),function(){
		var name = $(this).attr('name');
		name = name.replace('[', "");
		name = name.replace(']', "");
		oldValue[name]= $(this).val();
		console.log(name);
		if ($(this).val() =="") {
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
	})

	if(count > 0) {
		if(oldValue !== ""){
			$.each(oldValue, function(key, value) {
				//console.log('#'+key+'-text-error');
				$('#'+key).val(value);
				if(value == "") {
					$('#'+key + "-text-error").html("* Required").show();
					console.log(key);
				} else {
					$('#'+key + "-text-error").html("").hide();
				}
			});
		}
	}else{
		document.getElementById("save-evaluation").submit();
	}


}

