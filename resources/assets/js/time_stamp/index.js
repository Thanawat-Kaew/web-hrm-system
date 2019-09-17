$(document).ready(function(){
	$('.time-clock').on('click', '.time_stamp', function(){
		// window.open("<?php echo route('time_stamp');?>");
		window.open('/index/timestamp');
	})
})