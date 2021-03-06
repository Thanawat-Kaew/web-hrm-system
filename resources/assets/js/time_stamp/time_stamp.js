function msg_success(){
	Swal.fire({
		title: 'บันทึกข้อมูลสำเร็จ',
		text: "",
		type: 'success',
	}).then((result) =>{
		if (result.value)
		{
			window.location.reload();
		}
	})
}
$(document).ready(function() {

/*$( "#pass_emp" ).keyup(function() {
		var a = $(this).val();
  		alert(a);
  	});*/
  	$('.submit-add-timestamp').click(function(){
  		var selectedOptions = $('.type-time option:selected');
  		var type_time       = selectedOptions.val();
  		//alert(type_time);
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
				if(result.status == "failed"){
					Swal.fire(result.message1, result.message2,'warning');
				} else{
					msg_success()
				}
			},
			error : function(errors)
			{
				console.log(errors);
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

