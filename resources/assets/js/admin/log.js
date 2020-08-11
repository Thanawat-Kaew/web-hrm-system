$(document).ready(function(){
	$('.cancel').click(function(){
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่ ?',
			text: "ที่จะยกเลิกการตั้งค่านี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			textSize: 20,
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่!'
		}).then((result) =>{
			if (result.value){
				window.location.href = "/admin/admin_main";
				msg_waiting()
			}
		})
	})

	$('.save').click(function(){
		Swal.fire({
			title: 'คุณเพิ่มรายการนี้เรียบร้อย',
			type: 'success',
			showCancelButton: false,
			confirmButtonText: 'ปิด'

		}).then((result) =>{
			if (result.value){
				window.location.href = "/admin/admin_main";
				msg_waiting()
			}
		})
	})

	$('.confirm-delete-employee').click(function(){
		var id = $(this).data('id');
		//alert(id);
		//console.log(id);
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะอนุมัติการลบข้อมูลพนักงานคนนี้ !",
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
					url: $('#confirm-delete-employee-url').data('url'),
					data: {'id'	    : id
				}
			});
			Swal.fire(
				'อนุมัติ!',
				'คุณได้ทำการอนุมัติการลบข้อมูลพนักงานคนนี้เรียบร้อย',
				'success').then((result) =>{
					if (result.value)
					{
						window.location.reload();
					}
				})
			}
		})
	});

	$('.cancel-delete-employee').click(function(){
		var id = $(this).data('id');
		alert(id);
		//console.log(id);
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะไม่อนุมัติการลบข้อมูลพนักงานคนนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่, ไม่อนุมัติ!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type: "POST",
					url: $('#cancel-delete-employee-url').data('url'),
					data: {'id'	    : id
				}
			});
			Swal.fire(
				'อนุมัติ!',
				'คุณได้ทำการไม่อนุมัติการลบข้อมูลพนักงานคนนี้เรียบร้อย',
				'success').then((result) =>{
					if (result.value)
					{
						window.location.reload();
					}
				})
			}
		})
	});
});