$(document).ready(function() {

/*$( "#pass_emp" ).keyup(function() {
		var a = $(this).val();
  		alert(a);
  	});*/
  	$('.submit-add-timestamp').click(function(){
  		var selectedOptions = $('.type-time option:selected');
  		var type_time       = selectedOptions.val();
  		var pass            = $('#pass_emp').val();
		/*console.log(pass);
		alert(pass);
		alert(type_time);*/
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type   : "POST",
			url    : $('#add-timestamp').data('url'),
			data   : {
				'type_time' : type_time,
				'pass'      : pass
			},
			success: function (result) {
				//alert("success"+type_time);
				if(result.status == "failed_password"){
					alert("password ผิด");
				}
				if(result.status == "failed_timein"){
					alert("คุณลงเวลาเข้าทำงานแล้ว");
				}else if(result.status == "success_timein"){
					//alert("ลงเวลาเข้าทำงานสำเร็จ");
					Swal.fire(
						'Good job!',
						'You clicked the button!',
						'success',{
							showConfirmButton: false,
						}
						)
				}else if(result.status == "failed_breakout"){
					alert("คุณลงเวลาพักกลางวันแล้ว");
				}else if(result.status == "success_breakout"){
					//alert("ลงเวลาพักกลางวันสำเร็จ");
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Your work has been saved',
						showConfirmButton: false,
						timer: 1500
					})
				}else if(result.status == "failed_breakin"){
					alert("คุณลงเวลาเข้าทำงานช่วงบ่ายแล้ว");
				}else if(result.status == "success_breakin"){
					//alert("ลงเวลาเข้าทำงานช่วงบ่ายสำเร็จ");
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Your work has been saved',
						showConfirmButton: false,
						timer: 1500
					})
				}else if(result.status == "failed_timeout"){
					alert("คุณลงเวลาออกงานแล้ว");
				}else if(result.status == "success_timeout"){
					//alert("คุณลงเวลาออกงานสำเร็จ");
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Your work has been saved',
						showConfirmButton: false,
						timer: 1500
					})
				}
			},
			error : function(errors)
			{
				/*console.log(errors);*/
			}
		});

	});

// Create two variable with the names of the months and days in an array
var monthNames = [ "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ];
var dayNames= ["วันอาทิตย์","วันจันทร์","วันอังคาร","วันพุธ","วันพฤหัสบดี","วันศุกร์","วันเสาร์"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
},1000);


setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
},1000);


setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
}, 1000);



});