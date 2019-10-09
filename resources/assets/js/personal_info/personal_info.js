$(function(){
	$('.sidebar-toggle').hide();

	$('.amendment').click(function(){
		var	id = $(this).data('id');
		// alert(id);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getFormAmendmentEmployee',
			'id'	: id
		},
		success: function (result) {
			var title = "<h4 style='color: red;'>แจ้งแก้ไขข้อมูล <small> | Edit Employee</small></h4>"
			showDialog(result.data,title);
		},
		error : function(errors)
		{
			console.log(errors);
		}
	})
	})

	function showDialog(form,title, oldValue='',not_match){
		var box = bootbox.dialog({
			title: title,
			message: form,
			size: 'large',
			onEscape: true,
			backdrop: 'static',
			buttons: {
				fi: {
					label: 'ส่งคำร้อง',
					className: 'btn-info',
					callback: function(){

					}
				},
				fum: {
					label: 'ยกเลิก',
					className: 'btn-warning',
					callback: function(){
						

					}
				}
			}
		})

		box.on('shown.bs.modal', function(){
			$('body').addClass('modal-open');
			if(oldValue !== ""){
				$.each(oldValue, function(key, value) {
					$('#'+key).val(value);
					if(value == "") {
						$('#'+key + "-text-error").html("* Required").show();
					} else {
						$('#'+key + "-text-error").html("").hide();
					}
				});
			}
			if(not_match){
				$('#confirm_password-text-error').html("Please try password again").show();
			}else{
				$('#confirm_password-text-error').html("Please try password again").hide();
			}
		})
	};
})