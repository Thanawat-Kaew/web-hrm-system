$(document).ready(function() {

$('.add-part').click(function(){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
        type: 'POST',
        url: $('#ajax-center-url').data('url'),
        data: {method : 'getFormEvaluation'},
        success: function (result) {
        	console.log(result);
        	// result.data;
            // var title = "<h4 style='color: red;'>แบบฟอร์มลา <small> | Leave Form</small></h4>"
            // showDialog(result.data,title)
        },
        error : function(errors)
        {
            console.log(errors);
        }
    })
})

// function showDialog(form,title){
//     var box = bootbox.dialog({ 
//         title: title,
//         message: form,
//         size: 'large',
//         onEscape: true,
//         backdrop: true,
//         buttons: {
//             fi: {
//                 label: 'บันทึก',
//                 className: 'btn-info',
//                 callback: function(){

//                 }
//             },
//             fum: {
//                 label: 'ยกเลิก',
//                 className: 'btn-warning',
//                 callback: function(){
//                 }
//             }
//         }
//     })

//     $("#group-part").on('click',".add-more", function(){
//     	$(this).closest(".new-part").find(".selected-question").append($(".copy").html());
//     })

//     $("#group-part").on("click",".remove", function(){
//     	$(this).parents('.control-group').remove(); x--;
//     })

// };
})


























// 	var max_fields = 15;
// 	var x = 1;

// 	$(".add-part").click(function(e){ 
// 		e.preventDefault();
// 		if(x < max_fields){
// 			x++;
// 			$("#group-part").append('<div class="col-md-12 new-part"><div class="panel panel-default">'+
// 				'<div class="panel-body"><label>ชื่อตอน </label><input type="text" name="add-name" '+
// 				'class="form-control" placeholder="ชื่อตอน..."><br><label>คำถาม</label> '+
// 				'<button class="btn btn-success pull-right add-more btn-sm" type="button"><i class="glyphicon '+
// 				'glyphicon-plus"></i> เพิ่ม</button><div class="control-group input-group"'+
// 				'style="margin-top:10px"><input type="text" name="addmore[]" class="form-control"'+
// 				'placeholder="คำถาม"><div class="input-group-btn"><button class="btn btn-warning '+
// 				'remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>'+
// 				'</div></div><div class="selected-question"></div><div class="copy hide">'+
// 				'<div class="control-group input-group" style="margin-top:10px"><input type="text"'+
// 				'name="addmore[]" class="form-control" placeholder="คำถาม"><div class="input-group-btn"> '+
// 				'<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove">'+
// 				'</i> ลบ</button></div></div></div><br><div class="col-md-6"><label>เลือกรูปแบบคำตอบ</label>'+
// 				'<select class="form-control" style="width: 100%;"><option selected="selected">เลือกรูปแบบ...'+
// 				'</option><option>รูปแบบ 1</option><option>รูปแบบ 2</option><option>รูปแบบ 3</option>'+
// 				'</select><br></div><div class="col-md-6"><label>เปอร์เซนต์ (%)</label><input type="number"'+
// 				'name="percen" class="form-control" placeholder="30"></div></div></div>');
// 		}
// 	});

// 	$("#group-part").on('click',".add-more", function(){
// 		$(this).closest(".new-part").find(".selected-question").append($(".copy").html());
// 	})

// 	$("#group-part").on("click",".remove", function(){
// 		$(this).parents('.control-group').remove(); x--;
// 	})

// });
