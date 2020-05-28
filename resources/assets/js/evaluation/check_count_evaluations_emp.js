$(document).ready(function() {
	msg_waiting()

	$('#topic_name').on('change', function(){ // dropdown เลือกหัวข้อการประเมิน
		msg_waiting();
		var id_topic = $(this).val();
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type : 'POST',
			url  : $('#ajax-center-url').data('url'),
			data : {
				'method' : 'getFormCheckCountEvaluationEmployee',
				'id_topic': id_topic
			},
			success:function(result){
				if(result.data !== ""){
					$('#show_data').html(result.data.form);
					msg_close();
					$('.send_message').on('click', '.form_email', function(){
						msg_waiting();
						var id_department = $(this).data('id_department');
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
							type: 'POST',
							url: $('#ajax-center-url').data('url'),
							data: {method : 'getFormEmail',
								'id_department'    : id_department
							},
							success: function (result) {
								var title = "<h4 style='color: red;'>แบบฟอร์มการส่งอีเมล์ <small> | Form E-mail Sender</small><img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_gmail.jpg'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_email.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_hotmail.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_outlook.png'></h4>"
								showDialog(result.data,title);
							},
							error : function(errors){
								console.log(errors);
							}
						})
					})
				}
			},
			error : function(errors){
				msg_close();
				console.log(errors);
			}
		});
	})


});

function showDialog(form,title, oldValue='', errors='')
{
	var box = bootbox.dialog({
		title: title,
		message: form,
		size: 'large',
		onEscape: true,
		backdrop: 'static',
		buttons: {
			fi: {
				label: 'ส่ง',
				className: 'btn-info',
				callback: function(){
					if (title == "<h4 style='color: red;'>แบบฟอร์มการส่งอีเมล์ <small> | Form E-mail Sender</small><img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_gmail.jpg'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_email.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_hotmail.png'> <img class='pull-right' style='width:50px; height:50px;' src='/public/image/icon_outlook.png'></h4>") {
						formSendEmail(form, title);
					}
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
	//console.log(confirm_password);
	box.on('shown.bs.modal', function(){
		$('body').addClass('modal-open'); //scroll mouse
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

		if(errors !== ""){
			jQuery.each(errors, function(k, v){
				$('#'+k+'-text-error').html(v).show();
			})
		}
	})
}

function formSendEmail(form, title)
{
	var count     = 0;
	var oldValue  = {};
	//console.log(oldValue);
	jQuery.each($('.required'), function(){
		var name = $(this).attr('id');
		oldValue[name] = $(this).val();
		if($(this).val() == ""){
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
			$(this).css({"border" : "1px solid lightgray"});
		}
	});

	if(count > 0){
		showDialog(form, title, oldValue);
	}else{
		sendEmail(form, title);
	}
}

function sendEmail(form, title)
{
	var name_sender   = $('#name_sender').val();
	var email_sender  = $('#email_sender').val();
	var name_reciver  = $('#name_reciver').val();
	var email_reciver = $('#email_reciver').val();
	var topic         = $('#topic').val();
	var details       = $('#details').val();
	//alert(details);
	$.ajax({
		headers	: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type   	: 'POST',
		url    	: $('#send_email').data('url'),
		data 	: {
					'name_sender'   : name_sender,
					'email_sender'  : email_sender,
					'name_reciver'  : name_reciver,
					'email_reciver' : email_reciver,
					'topic'         : topic,
					'details'		: details
		},
		success: function (response) {
			var data_resp = jQuery.parseJSON(response);
			console.log(data_resp);
			if(data_resp.status == "success"){
				Swal.fire(
				{
					title: 'คุณส่งอีเมล์นี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'
				}).then((response) =>{
					window.location.reload();
				})
			}else{
				showDialog(form, title, oldValue,not_match, data_resp.message);
			}
		},
		error : function(errors){
			alert("Don't send email");
			msg_close();
			//console.log(errors);
		}
	})
}

export{showDialog};


