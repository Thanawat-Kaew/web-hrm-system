$(document).ready(function(){
	$('.post-confirm-send-create-evaluation').click(function(){  // กด อนุมัติ
		//alert("confirm");
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
});