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