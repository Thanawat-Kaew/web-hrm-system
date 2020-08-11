$(document).ready(function (){

	$('.datepicker').datepicker({format: "yyyy-mm-dd"});
	$('.yearpicker').datepicker({format: "yyyy",viewMode: "years", minViewMode: "years"});

	// Filter Year.
	$('#myInput').keyup(function(){
		search_data_tbl();
	})

  	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    })

	$('.save').click(function(){

		var selectedOptions 	= $('.set_holiday_day option:selected');
		var set_holiday_day    	= selectedOptions.val();
		var compensation 		= $('input[name=check_stop_compensation]').is(':checked')?'1':'0';

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#add-set_holiday').data('url'),
			data: {
				set_year        		: $('#set_year').val(),
				set_holiday_day 		: set_holiday_day,
				check_stop_compensation	: compensation,
				set_date 				: $('#set_date').val(),
			},
			success: function (result) {
				var data_resp = jQuery.parseJSON(result);
				if(data_resp.status == "success"){
					Swal.fire({
						title: 'คุณเพิ่มรายการนี้เรียบร้อย',
						type: 'success',
						showCancelButton: false,
						confirmButtonText: 'ปิด'

					}).then((result) =>{
						window.location.reload();

					})
				}else{

					Swal.fire({
						title: 'คุณเพิ่มรายการนี้ไม่สำเร็จ',
						text: 'มีข้อมูลนี้ในระบบแล้ว กรุณาตรวจสอบข้อมูล',
						type: 'error',
						showCancelButton: false,
						confirmButtonText: 'ปิด'
					})
				}
			},
			error : function(errors)
			{
				//console.log(errors);
				Swal.fire({
						title: 'ไม่สามารถบันทึกข้อมูลได้',
						text: 'กรุณากรอกข้อมูลใหม่อีกครั้ง',
						type: 'error',
						showCancelButton: false,
						confirmButtonText: 'ตกลง'
					}).then((result) =>{
						window.location.reload();

					})
			}
		})
	})

	$('.cancel').click(function(){
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่ ?',
			text: "ที่จะยกเลิกการตั้งค่านี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			textSize: 20,
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่!'
		}).then((result) =>{
			if (result.value){
				window.location.href = "/leave";
				msg_waiting()
			}
		})
	})

	$('.delete-data').click(function(){
		var url=$(this).data('href');
		Swal.fire(
		{
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะลบรายการนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ลบ',
			confirmButtonText: 'ใช่, ลบเดี่ยวนี้!'
		}).then((result) => 
			{
				if (result.value) 

				{
					postDelete(url); 
				}
			})
	})
})

function postDelete(url)
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: "POST",
		url: url,
		success: function(result){
			if(result.status == "success"){
				Swal.fire(
				{
					title: 'คุณลบรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((result) =>{

					if (result.value){
						window.location.reload();
					}
				})
			} else {
				alert(result.message);
			}
		},	
		error : function(errors){
			console.log(errors);
		}
	});
}

function search_data_tbl() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[2];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}       
	}
}