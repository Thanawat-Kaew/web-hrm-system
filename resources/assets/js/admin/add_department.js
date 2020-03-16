$(document).ready(function(){

	$('.btn-save').click(function(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#add-department').data('url'),
			data: {
				id_department        		: $('.get_id_department').val(),
				name_department 			: $('.get_name_department').val(),
			},
			success: function (result) {
				var data_resp = jQuery.parseJSON(result);
				if(data_resp.status == "success"){
					Swal.fire({
						title: 'คุณเพิ่มรายการนี้เรียบร้อย',
						type: 'success',
						showCancelButton: false,
						confirmButtonText: 'ปิด'
					}).then((result) =>{
						window.location.reload();
					})
				}else if(data_resp.status == "failed"){
					Swal.fire({
						title: 'มี ID หรือ NAME ที่ซ้ำกับระบบ',
						text: 'ไม่สามารถบันทึกข้อมูลได้',
						type: 'error',
						showCancelButton: false,
						confirmButtonText: 'ปิด'

					}).then((result) =>{
						if (result.value){
							// window.location.reload()
						}
					})
				}else if(data_resp.status == "failed_fied_err"){
					Swal.fire({
						title: 'คุณกรอกข้อมูลไม่ครบถ้วน',
						text: 'กรุณากรอกข้อมูล',
						type: 'warning',
						showCancelButton: false,
						confirmButtonText: 'ปิด'

					}).then((result) =>{
						if (result.value){
							// window.location.reload()
						}
					})
				}
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})


	})

	$('.btn-cancel').click(function(){
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
				// window.location.reload()
				// msg_waiting()
			}
		})
	})


})