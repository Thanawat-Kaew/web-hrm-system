$(document).ready(function() {

    $('#myTable').DataTable({
        stateSave : true
    });

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
                //  title: 'คุณแน่ใจหรือไม่?',
                //  text: "ที่จะลบรายการนี้ !",
                //  type: 'warning',
                //  showCancelButton: true,
                //  confirmButtonColor: '#3085d6',
                //  cancelButtonColor: '#d33',
                //  cancelButtonText: 'ไม่ลบ',
                //  confirmButtonText: 'ใช่, ลบเดี่ยวนี้!'
                // }).then((result) =>
                // {
                //  if (result.value){
                //      window.location.reload();
                //  }
                // })
                console.log(result);
            },
            error : function(error)
            {
                console.log(error);
            }
        })
    });

    $('#myTable').on("click",'.delete-id_topic',function(){
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
    }).then((result) =>{
            if (result.value){
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
                Swal.fire({
                type: 'success',
                title: 'คุณลบรายการนี้เรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                    window.location.reload();
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