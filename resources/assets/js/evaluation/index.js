$(document).ready(function(){
	msg_waiting()
	$('.assess-evaluation').on('click', '.assessment', function(){
		window.open('/evaluation/human_assessment','_self','location=yes,left=400,top=30,height=700,width=950,scrollbars=yes,status=yes');
	});

})