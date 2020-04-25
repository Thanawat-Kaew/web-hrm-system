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

	$('.post-confirm-send-create-evaluation').click(function(){  // กด อนุมัติ
		// alert("confirm");
		var id = $(this).data('id');
		Swal.fire({
			title: 'คุณแน่ใจหรือไม่?',
			text: "ที่จะส่งการประเมินนี้ !",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'ไม่ใช่',
			confirmButtonText: 'ใช่, ยืนยัน!'
		}).then((result) => {
			if (result.value) {
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
				type: "POST",
				url: $('#post_confirm-create-evaluations').data('url'),
				data: {'id'	    : id
				}
			});
				Swal.fire(
					'ยืนยัน!',
					'คุณได้ทำการส่งการประเมินเรียบร้อย',
					'success').then((result) =>{
						if (result.value)
						{
							window.location.reload();
						}
					})
				}
			})
	})

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

	$('.start_date, .end_date').datepicker({format: "yyyy-mm-dd"});

	$('.set_time').click(function(){
		 $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
            type: 'POST',
            url: $('#ajax-center-url').data('url'),
            data: {method : 'getFormSetTimeEvaluation'},
            success: function (result) {
                var title = "<h4 style='color: red;'>กำหนดเวลาการประเมินผล <small> | Set time evaluation</small></h4>"
                showDialog(title,result.data)
            },
            error : function(errors)
            {
                console.log(errors);
            }
        })
	})
})

function showDialog(title,form,oldValue=''){
    var box = bootbox.dialog({ 
        title: title,
        message: form,
        size: 'xlarge',
        onEscape: true,
        backdrop: 'static',
        buttons: {
            fi: {
                label: 'บันทึก',
                className: 'btn-info',
                callback: function(){
                    sendRequest(title,form);
                }
            },
            fum: {
                label: 'ยกเลิก',
                className: 'btn-warning',
                callback: function(){
                }
            }
        }
    })

    box.on("shown.bs.modal", function() {

        $('body').addClass('modal-open');
        $('.start_date, .end_date').datepicker({format : "yyyy-mm-dd"});

        if(oldValue !== ""){
            $.each(oldValue, function(key, value) {
                $('#'+key).val(value);
                if(value == "") {
                    $('#'+key + "-text-error").html("* Required").show();
                } else {
                    $('#'+key + "-text-error").html("").hide();
                }
            });
        }
    })
}

function sendRequest(form, title){
    msg_waiting();       
    var count            = 0;
    var oldValue         = {};

    jQuery.each($('.required'),function(){
        var name = $(this).attr('id');
        oldValue[name]= $(this).val();
        if ($(this).val() =="") {
            count++
            $(this).css({"border" : "1px solid red"});
        } else {
            $(this).css({"border" : "1px solid lightgray"});
        }
    })

    if(count > 0) {
        showDialog(form, title, oldValue);
    } else {

        // saveSetTime(form, title, oldValue);
    }
}

function saveSetTime(form, title, oldValue)
{

}

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