$(document).ready(function() {
	msg_waiting()
	$('.add-part').click(function(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormEvaluation'},
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

	$("#group-part").on('click',".add-more", function(){
		$(this).closest(".new-part").find(".selected-question").append($(".copy").html());
	})
	$("#group-part").on("click",".remove", function(){
		$(this).parents('.control-group').remove();
	})

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


























	// var max_fields = 15;
	// var x = 1;

	// $(".add-part").click(function(e){ 
	// 	e.preventDefault();
	// 	if(x < max_fields){
	// 		x++;
	// 		$("#group-part").append('<div class="col-md-12 new-part"><div class="panel panel-default">'+
	// 			'<div class="panel-body"><label>ชื่อตอน </label><input type="text" name="add-name" '+
	// 			'class="form-control" placeholder="ชื่อตอน..."><br><label>คำถาม</label> '+
	// 			'<button class="btn btn-success pull-right add-more btn-sm" type="button"><i class="glyphicon '+
	// 			'glyphicon-plus"></i> เพิ่ม</button><div class="control-group input-group"'+
	// 			'style="margin-top:10px"><input type="text" name="addmore[]" class="form-control"'+
	// 			'placeholder="คำถาม"><div class="input-group-btn"><button class="btn btn-warning '+
	// 			'remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>'+
	// 			'</div></div><div class="selected-question"></div><div class="copy hide">'+
	// 			'<div class="control-group input-group" style="margin-top:10px"><input type="text"'+
	// 			'name="addmore[]" class="form-control" placeholder="คำถาม"><div class="input-group-btn"> '+
	// 			'<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove">'+
	// 			'</i> ลบ</button></div></div></div><br><div class="col-md-6"><label>เลือกรูปแบบคำตอบ</label>'+
	// 			'<select class="form-control" style="width: 100%;"><option selected="selected">เลือกรูปแบบ...'+
	// 			'</option><option>รูปแบบ 1</option><option>รูปแบบ 2</option><option>รูปแบบ 3</option>'+
	// 			'</select><br></div><div class="col-md-6"><label>เปอร์เซนต์ (%)</label><input type="number"'+
	// 			'name="percen" class="form-control" placeholder="30"></div></div></div>');
	// 	}
	// });

	// $("#group-part").on('click',".add-more", function(){
	// 	$(this).closest(".new-part").find(".selected-question").append($(".copy").html());
	// })

	// $("#group-part").on("click",".remove", function(){
	// 	$(this).parents('.control-group').remove(); x--;
	// })
