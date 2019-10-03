function msg_waiting(){
	Swal.fire({
		title: '<i class="fa fa-spinner fa-spin" style="font-size:30px"></i>',
		html: '<h3>Please waiting....</h3>',
		showConfirmButton: false,
		allowOutsideClick: false
	})
}

function msg_close(){
	Swal.close();
}

function msg_success(){
	Swal.fire({
		type: 'success',
		title: 'Data has been saved',
		showConfirmButton: false,
		timer: 1500
	})
}