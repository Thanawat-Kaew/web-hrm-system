$(document).ready(function() {
	msg_waiting()

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass   : 'iradio_flat-green'
	})

	$('.cancel_evaluation').click(function(){
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่ ?',
			text: "ที่จะยกเลิกการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			textSize: 20,
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่'
		}).then((result) =>{
			if (result.value)
			{
				window.location.href = "/evaluation/human_assessment";
			}
		})
	})


	//var theTotal = 0;
	$('.score').on('ifChecked', function(event){
		//alert(Number($(this).val()));
		var group = $(this).attr("data-group");
		//alert(group);
		$('#total-question-'+group).text($(this).val());
		//var name = $(this).attr("name");
		//alert(name);
		//theTotal = Number(theTotal) + Number($(this).val());

		var parts    = $(this).attr("data-part");
		//alert(parts);
		//console.log("parts"+parts);
		/*$.each(parts).each(function(){
			alert($(this).val());
		})*/
		var question = $(this).attr("data-question");
		//alert(question);
		//console.log("question"+question);
		//alert(theTotal);
		var theTotal = 0;
		var s = $('#total-question-'+parts+'-'+question).val();
		alert(s);
		var a = theTotal + parseInt(s);
		//alert(a);
		/*$.each($("input[name='format_answer-"+parts+'-'+question+"']:checked"), function(){
			theTotal = theTotal + $(this).val();
		})
		$('#total-part-'+parts).text(theTotal);*/
		//$(this).val();

		//var total = 0;
    	/*$("input[name='format_answer-"+parts+'-'+question+"']").each(function() {
        	total += parseFloat($(this).val());
    	});*/



    	//$('#total-part-'+parts).text(total);

		//var a = $(this).ifChanged($(this).val());
		//alert(a);
		//var parts = $(this).val();
		//alert(parts);
		//var radioValue = $("input[name='format_answer-"+parts+'-'+question+"']:checked").val();
		//alert(radioValue);

		/*$(this).each(function(){*/
      		//lert($(this).val())
      		//theTotal = Number(theTotal) + $("input[name='format_answer-"+parts+'-'+question+"']:checked").val();
    	/*});*/
		//$('#total-part-'+parts).text(theTotal);


		/*theTotal = Number(theTotal) + Number($(this).val());  // ถ้า value แล้วเอามา+ ไม่ใช่ กดแล้วบวก
		$("#sum").val(Number($("#num1").val()) + Number($("#num2").val()));
		//$('#part-total-'+parts).text($(this).val());
		$('#part-total-'+parts).text($(this).val());*/
	});



		//$('#part-total-'+parts).text($(this).val());
	/*$('input[data-part="'+parts+'"]:radio').on('ifChanged', function(event){
		alert("55");
		$('input:radio:checkbox').each(function(){
			theTotal += parseInt($(this).val());
		});
		$('#part-total-'+parts).text(theTotal);
	});*/

	//$('.total').text($(this).val());
});
