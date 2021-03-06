$(document).ready(function(){

	$('#myTable').dataTable({
		stateSave : true
	});

    $('#myInput').keyup(function(){
        search_data_tbl();
    })
})

$(function(){
    $('.table').on('click', '.view-data-request', function(){
		msg_waiting()
		var	id = $(this).data('id');
		//console.log(id)
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewDataRequest',
			'id'	    : id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>ข้อมูลที่แก้ไข <small> | Edit Employee</small></h4>"
				//showDialog(result.data,title);
				bootbox.dialog({
					title: title,
					message: result.data,
					size: 'large',
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
				msg_close();
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	})

	msg_waiting()
    $('.table').on('click', '.btn-confirm-data-request', function(){
		//alert("confirm");
		var id = $(this).data('id');
		console.log(id);
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
						url: $('#confirm-ajax-center-url').data('url'),
						data: {'method' : 'getViewDataRequest',
						'id'	    : id
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

    $('.table').on('click', '.btn-cancel-data-request', function(){
		var id = $(this).data('id');
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
							url: $('#cancel-ajax-center-url').data('url'),
							data: {'method' 	   : 'getViewDataRequest',
							'id'	           : id,
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

function search_data_tbl() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}