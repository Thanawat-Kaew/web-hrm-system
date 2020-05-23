$(document).ready(function(){

	$(".alert").delay(3000).slideUp(300, function() {
    	$(this).alert('close');
	});

	$('.post-confirm-send-create-evaluation').click(function(){  // กด อนุมัติ
		// alert("confirm");
		var id = $(this).data('id');
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะส่งการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่, ยืนยัน!'
		}).then((result) => {
			if (result.value) {
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: "POST",
				url: $('#post_confirm-create-evaluations').data('url'),
				data: {'id'	    : id
				}
			});
				Swal.fire(
					'ยืนยัน!',
					'คุณได้ทำการส่งการประเมินเรียบร้อย',
					'success').then((result) =>{
						if (result.value)
						{
							window.location.reload();
						}
					})
				}
			})
	})

	// $('.add-evaluation').on('click', function() {
	// 	createNewEvaluation();
	// })
	$('.btn-remove-topic').click(function(){
		//alert("55");
		var url = $(this).data('href');
		Swal.fire(
		{
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะลบรายการนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ลบ',
			confirmButtonText: 'ใช่, ลบเดี่ยวนี้!'
		}).then((result) =>
		{
			if (result.value){
				postDelete(url);
			}
		})
	})
});

function postDelete(url){
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: url,
		success: function(result){
			if(result.status == "success"){
				Swal.fire(
				{
					title: 'คุณลบรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((result) =>{

					if (result.value){
						window.location.reload();
					}
				})
			}else{
				alert(result.message);
			}
		},
		error : function(errors){
			console.log(errors);
		}
	})
}

// function createNewEvaluation()
// {
// 	$.ajax({
// 		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
// 		type: 'POST',
// 		url: $('#ajax-center-url').data('url'),
// 		data: {method : 'createNewEvaluation' },
// 		success: function (result) {
// 			window.location = $("#add-evaluation-url").data('url');
// 		},
// 		error : function(error)
// 		{
// 			console.log(error);
// 		}
// 	})
// }
