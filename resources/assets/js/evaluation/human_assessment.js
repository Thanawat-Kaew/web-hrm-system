$(document).ready(function() {
	msg_waiting()

	$('#myTable').dataTable();
	// Filter Year.
	$('#myInput').keyup(function(){
		search_data_tbl();
	})

	// $('.view_score').on('click',function () {
	// 	bootbox.dialog({
	// 			title: '<h4 style="text-align: center; font-size : 16px;"> จัดการข้อมูล | Data Management</h4>',
	// 			message: 'kkk',
	// 			size: 'xlarge',
	// 			onEscape: true,
	// 			backdrop: true
	// 	})
	// })
})

function search_data_tbl() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
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