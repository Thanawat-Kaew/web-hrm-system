$(document).ready(function(){

    $('.logout').click(function(){
        confirm();
    })
})

function confirm(){
    $.ajax({
        headers : {'X-CSRF-TOKEN': $('input[name=_token').attr('value')},
        type    : 'POST',
        url     : $('#logout-form').data('url'),
    });
    Swal.fire({
        title: 'ต้องการออกจากระบบใช่หรือไม่?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ออกเดี๋ยวนี้!',
        cancelButtonText: 'ไม่'
    }).then((result) => {
        if (result.value) {
            window.location.href = 'http://hrm.system.io/logout_admin';
        }
    })
}

function msg_waiting(){
    Swal.fire({
        title: '<i class="fa fa-spinner fa-spin" style="font-size:30px"></i>',
        html: '<h3>รอสักครู่...</h3>',
        showConfirmButton: false,
        allowOutsideClick: false,
        customClass: 'swal-wide',
        timer: 1000,
    })
}
