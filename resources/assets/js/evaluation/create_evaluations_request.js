$(document).ready(function(){

	$('#myTable').dataTable();

    $('.table').on('click', '.btn-confrim', function(){
		//alert("confirm");
		var id = $(this).data('id');
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะอนุมัติการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่, อนุมัติ!'
		}).then((result) => {
			if (result.value) {
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: "POST",
				url: $('#confirm-create-evaluation').data('url'),
				data: {'id'	    : id
				}
			});
				Swal.fire(
					'อนุมัติ!',
					'คุณได้ทำการอนุมัติเรียบร้อย',
					'success').then((result) =>{
						if (result.value)
						{
							window.location.reload();
						}
					})
				}
			})
		})

    $('.table').on('click', '.btn-cancel', function(){
		var id = $(this).data('id');
		//alert(id);
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะไม่อนุมัติการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่, อนุมัติ!'
		}).then((result) => {
			if (result.value) {
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: "POST",
				url: $('#cancel-create-evaluation').data('url'),
				data: {'id'	    : id
				}
			});
				Swal.fire(
					'อนุมัติ!',
					'คุณได้ทำการอนุมัติเรียบร้อย',
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