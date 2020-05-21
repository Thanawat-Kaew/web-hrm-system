$(document).ready(function(){

	$('input[type="radio"].flat-red').iCheck({
		radioClass: 'iradio_flat-red'
	});

	$('input[type="radio"].flat-green').iCheck({
		radioClass   : 'iradio_flat-green'
	})

	$('input[type="radio"]').on('ifChecked', function(){
		var emergency_status = $("input[name=iCheck]:checked").val();

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#set-emergency').data('url'),
			data : {
				emergency_status  : emergency_status
			},
			success: function(response){
				if(response.status == "success"){
					Swal.fire({
						type: 'success',
						title: '',
						html: response.data,
						showConfirmButton: false,
						timer: 2000
					})
				}else{
					console.log(response);
				}
			},
			error: function(errors){
				console.log(errors);
			}
		})
	})
});