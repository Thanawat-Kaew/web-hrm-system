$(document).ready(function() {
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



	/*$('.type-time').change(function(){
		var selectedOptions = $('.type-time option:selected');
		var type_time       = selectedOptions.val();*/
		//alert(type_time);
		//alert(selectedOptions.text());
		//console.log(selectedOptions.text());
		//alert(selectedOptions.val());
		//console.log(selectedOptions.val());
		/*if(selectedOptions.val() == 1){ */// Time_in
			//alert(selectedOptions.text());
			/*$('.submit-add-timestamp').click(function(){*/
			//alert("submit-add-timestamp");
			//console.log(newDate);
			//var type_time = $('.type-time').val();
			//alert(type_time);
			//console.log(type_time);
			//alert(selectedOptions.val());
			//alert(type_time);
				/*$.ajax({
					headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
					type   : "POST",
					url    : $('#add-timestamp').data('url'),
					data   : { type_time : 'type_time'},
					success: function (result) {
						alert("success"+type_time);
						//msg_close();
								//console.log(id);
					},
					error : function(errors)
					{
						console.log(errors);
					}
				});
			});*/
		/*}*/
	/*});*/

	/*$('.type-time').change(function(){*/
		//$(this).find(':selected').addClass('selected').siblings('option').removeClass('selected');
		/*var selectedOptions = $('.type-time option:selected');
		var type_time       = selectedOptions.val();*/
		//alert(type_time);
		//alert(selectedOptions);
		//console.log(type_time);
		$('.submit-add-timestamp').click(function(){
			//var selectedOptions = $('select.type-time > option.ti').attr('value');
			var selectedOptions = $('.type-time option:selected');
			var type_time = selectedOptions.val();
			//var type_time       = selectedOptions.val();
			//alert(type_time);
			//console.log(type_time);
			alert(type_time);
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type   : "POST",
				url    : $('#add-timestamp').data('url'),
				data   : {'type_time' : type_time},
				success: function (result) {
					//alert("success"+type_time);
					//alert(result);
					//msg_close();
					//console.log(id);
					//console.log(result.data);
				},
				error : function(errors)
				{
					console.log(errors);
				}
			});
			//console.log(type_time);
		});
		//console.log(type_time);
	/*});*/

});

