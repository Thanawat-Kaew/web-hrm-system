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
			Swal.fire({
				title: 'กรุณากรอกเหตุผล',
				input: 'textarea',
				inputPlaceholder: 'Type your message here...',
				inputAttributes: {
					'aria-label': 'Type your message here'
				},
				showCancelButton: true
			}).then((result) => {
				if(result.value !== ''){
					// send update data.
				}else{
					Swal.fire(
				'ไม่สำเร็จ!',
				'กรุณากรอกเหตุผล สำหรับการไม่อนุมัติในครั้งนี้',
				'warning')
				}
			})

			
		}
	})
})