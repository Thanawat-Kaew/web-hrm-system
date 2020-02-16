$(document).ready(function(){
	msg_waiting()
	$('.assessment').click(function(){
		/*var id = $(this).data('id');
		//console.log(id);
		//window.open('/evaluation/human_assessment','_self','location=yes,left=400,top=30,height=700,width=950,scrollbars=yes,status=yes');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'peopleBeginEvaluation',
					id    : id},
			success: function (result) {
				window.open('/evaluation/human_assessment','_self','location=yes,left=400,top=30,height=700,width=950,scrollbars=yes,status=yes');
				//console.log(result);
			},
			error : function(error)
			{
				console.log(error);
			}
		})*/
	});

	$('.add-evaluation').on('click', function() {
		createNewEvaluation();
	})

    // $('#myTable').DataTable();

	// Filter Year.
	$('#myInput').keyup(function(){
		search_data_tbl();
	})

	/*$('.view-create-evaluation').click(function(){
		var	id = $(this).data('id');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: { id    :  id
			},
			success: function (result) {
				window.location = $("#view-create-evaluation-url").data('url');
			},
			error : function(error)
			{
				console.log(error);
			}
		})
	})*/

	$('.btn-remove-topic').click(function(){
		var url = $(this).data('href');
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
			if (result.value){
				postDelete(url); 
			}
		})
	})

	$(".content").on('click',".btn-remove-topic", function(){ // ลบการประเมิน
		var id = $(this).data('id');
		//console.log(id);
		//$(this).parents(".row-create-evaluation").remove();
		//alert("ok");
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'deleteCreateEvaluation',
			id  : id},
			success: function (result) {
				// // alert(result);
				// Swal.fire(
				// {
				// 	title: 'คุณแน่ใจหรือไม่?',
				// 	text: "ที่จะลบรายการนี้ !",
				// 	type: 'warning',
				// 	showCancelButton: true,
				// 	confirmButtonColor: '#3085d6',
				// 	cancelButtonColor: '#d33',
				// 	cancelButtonText: 'ไม่ลบ',
				// 	confirmButtonText: 'ใช่, ลบเดี่ยวนี้!'
				// }).then((result) => 
				// {
				// 	if (result.value){
				// 		window.location.reload();
				// 	}
				// })
				console.log(result);
			},
			error : function(error)
			{
				console.log(error);
			}
		})
	});

	$('#myInput').keyup(function(){
		search_data_tbl();
	})
})

function createNewEvaluation()
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
		url: $('#ajax-center-url').data('url'),
		data: {method : 'createNewEvaluation' },
		success: function (result) {
			window.location = $("#add-evaluation-url").data('url');
		},
		error : function(error)
		{
			console.log(error);
		}
	})
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

function postDelete(url){

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: 'POST',
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
	})
}