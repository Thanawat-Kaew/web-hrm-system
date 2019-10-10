msg_waiting()
$('.btn-confirm').click(function(){
	Swal.fire({
		title: 'คุณแน่ใจหรือไม่?',
		text: "ที่จะอนุมัติการแก้ไขข้อมูลนี้ !",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'ไม่ใช่',
		confirmButtonText: 'ใช่, อนุมัติ!'
	}).then((result) => {
		if (result.value) {
			Swal.fire(
				'อนุมัติ!',
				'คุณได้ทำการอนุมัติเรียบร้อย',
				'success')
		}
	})
})

$('.btn-cancel').click(function(){
	Swal.fire({
		title: 'คุณแน่ใจหรือไม่?',
		text: "ที่จะไม่อนุมัติการแก้ไขข้อมูลนี้ !",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'ไม่ใช่',
		confirmButtonText: 'ใช่, ไม่อนุมัติ!'
	}).then((result) => {
		if (result.value) {
			Swal.fire(
			'เรียบร้อย!',
			'คุณได้ทำการยกเลิกเรียบร้อย',
			'success')
		}
	})
})