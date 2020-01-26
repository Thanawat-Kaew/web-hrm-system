$(document).ready(function (){

	$('.datepicker').datepicker({format: "yyyy-mm-dd"});
	$('.yearpicker').datepicker({format: "yyyy",viewMode: "years", minViewMode: "years"});

	// Filter Year.
	$('#myInput').keyup(function(){
		search_data_tbl();
	})


	$('.save').click(function(){

		var selectedOptions 	= $('.set_holiday_day option:selected');
		var set_holiday_day    	= selectedOptions.val();

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#add-set_holiday').data('url'),
			data: {
				set_year        	: $('#set_year').val(),
				set_holiday_day 	: set_holiday_day,
				set_date 			: $('#set_date').val(),
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
						text: 'กรุณาตรวจสอบข้อมูล',
						type: 'error',
						showCancelButton: false,
						confirmButtonText: 'ปิด'
					})
				}
			},
			error : function(errors)
			{
				console.log(errors);
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
})

function search_data_tbl() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1,2,3];
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