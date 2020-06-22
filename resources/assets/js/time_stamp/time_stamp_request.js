$(function(){
	$('#myTable').dataTable({
		stateSave : true
	});

	$('.table').on('click','.view-data-request-time-stamp',function(){
		msg_waiting()
		var	id = $(this).data('id');
		//console.log(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewDataRequestTimeStamp',
			'id'	    : id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>ข้อมูลเวลาที่ขอลงเวลาย้อนหลัง <small> <br> Edit Employee</small></h4>"
				bootbox.dialog({
					title: title,
					message: result.data,
					size: 'small',
					onEscape: true,
					backdrop: 'static',
					buttons: {
						fum: {
							label: 'ปิด',
							className: 'btn-warning',
							callback: function(){
							}
						}
					}
				})
				//alert(result.data);
				//console.log(result.data);
				msg_close();
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	});

	msg_waiting()

	$('.table').on('click','.btn-confirm-data-request-time-stamp',function(){
		//alert("confirm");
		var id = $(this).data('id');

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
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: "POST",
				url: $('#confirm-data-request-time-stamp').data('url'),
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

	$('.table').on('click','.btn-cancel-data-request-time-stamp',function(){
	
	// $('.btn-cancel-data-request-time-stamp').click(function(){  // กดปฏิเสธ
		var id = $(this).data('id');
		//alert(id);
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
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
							type: "POST",
							url: $('#cancel-data-request-time-stamp').data('url'),
							data:{'id'	           : id,
							       'reason_reject' : result.value
						    }
					});
					Swal.fire(
						'สำเร็จ!',
						'คุณได้ปฏิเสธการ้องขอเรียบร้อย',
						'success'
						).then((result) =>{
							if (result.value)
							{
								window.location.reload();
							}
						})
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
});

