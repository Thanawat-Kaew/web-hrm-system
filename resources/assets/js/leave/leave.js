$(document).ready(function(){
    $('.dropup').on('click', '.add-leave', function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
            type: 'POST',
            url: $('#ajax-center-url').data('url'),
            data: {method : 'getFormLeave'},
            success: function (result) {
                var title = "<h4 style='color: red;'>แบบฟอร์มลา <small> | Leave Form</small></h4>"
                showDialog(result.data,title)
            },
            error : function(errors)
            {
                console.log(errors);
            }
        })
    })

    $('#myInput').keyup(function(){
        search_data_tbl();
    })

     $(function () {
    $('#myTable').DataTable()
  })
    $('#example2').DataTable()
})



function showDialog(form,title,oldValue='',oldCheck='',errors=''){
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
                    sendRequest(form, title);
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
    //.css({'background-color': '#222d32'});

    box.on("shown.bs.modal", function() {
        // checkbox
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        $('#start_time_hour').on('click', function(){
                getTimePicker($(this));
        });

        $('#end_time_hour').on('click', function(){
                getTimePicker($(this));
        });

        $(".form_datetime").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime1").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime2").datepicker({format: 'yyyy-mm-dd'});
        $(".form_datetime3").datepicker({format: 'yyyy-mm-dd'});

        $('.full_day').on('ifChecked', function(event){
            $('.full_day_leave').removeClass('hide');
            $('.form_datetime').addClass('required');
            $('.form_datetime1').addClass('required');
            $('.half_morning_leave').addClass('hide');
            $('.half_afternoon_leave').addClass('hide');
            $('.total_num').removeClass('hide');
        }).on('ifUnchecked', function(event){
            $('.full_day_leave').addClass('hide');
            $('.form_datetime').removeClass('required');
            $('.form_datetime1').removeClass('required')});

        $('.half').on('ifChecked', function(event){
            $('.half_morning_leave').removeClass('hide');
            $('.form_datetime2').addClass('required');
            $('.full_day_leave').addClass('hide');
            $('.half_afternoon_leave').addClass('hide');
            $('.total_num').addClass('hide');
        }).on('ifUnchecked', function(event){
            $('.half_morning_leave').addClass('hide');
            $('.form_datetime2').removeClass('required')});

        $('.hour').on('ifChecked', function(event){
            $('.half_afternoon_leave').removeClass('hide');
            $('.form_datetime3').addClass('required');
            $('.full_day_leave').addClass('hide');
            $('.half_morning_leave').addClass('hide');
            $('.total_num').addClass('hide');
        }).on('ifUnchecked', function(event){
            $('.half_afternoon_leave').addClass('hide');
            $('.form_datetime3').removeClass('required')});

        $('body').addClass('modal-open');

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

        if (oldCheck !== "") {
            $.each(oldCheck, function(key, value){
                if (value) {
                    $('#'+key).iCheck('check');
                    $('#edit-input-'+key).addClass('required');
                }else{
                    $('#'+key).iCheck('uncheck')
                    $('#edit-input-'+key).removeClass('required');
                }
            })
        }

        if(errors !== ""){
            jQuery.each(errors, function(k, v){
                $('#edit-input-'+k+'-text-error').html(v).show();
            })
        }
    })
}

function sendRequest(form, title){
    msg_waiting();
    var getDate1 = $(".form_datetime").datepicker('getDate');
    var getDate2 = $(".form_datetime1").datepicker('getDate');
    var getDate3 = $(".form_datetime2").datepicker('getDate');
    var getDate4 = $(".form_datetime3").datepicker('getDate');
    var getTime1  = parseInt($('#start_time_hour').val());
    var getTime2  = parseInt($('#end_time_hour').val());
    var diff_full_d = Math.ceil(((getDate2 - getDate1)/1000/3600/24)+1);
    var diff_full   = Math.ceil((diff_full_d)*8);
    var diffDays1   = Math.ceil(((getDate3 - getDate3)/1000/3600/24)+1);
    var diff_half_m_a = parseFloat((diffDays1 - 0.5)*8);
    var diff_leave_hour   = Math.ceil(getTime2 - getTime1);
       
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

    var oldCheck = {};
    jQuery.each($('.flat-red'),function(){
        var id = $(this).attr('id');
        var checked = $(this).prop('checked');
        oldCheck[id] = checked;

    })

    if(count > 0) {
        showDialog(form, title, oldValue,oldCheck);
    } else {

        addRequestLeave(form, title, oldValue,oldCheck,diff_full,diff_half_m_a,diff_leave_hour);
    }
}

function addRequestLeave(form, title, oldValue,oldCheck,diff_full,diff_half_m_a,diff_leave_hour){ //_f(full day), _h_m(half morning), _h_a(half afternoon)
    $.ajax({
        headers : {'X-CSRF-TOKEN': $('input[name=_token').attr('value')},
        type    : 'POST',
        url     : $('#add-request-leave').data('url'),
        data    : {
            leave_type          : $('#edit-input-leave-type').val(),
            format_leaves       : $('input[name=format_leaves]:checked').val(),
            format_leave_m_a    : $('input[name=format_leave]:checked').val(),
            start_date_f        : $('#input-form_datetime').val(),
            end_date_f          : $('#input-form_datetime1').val(),
            start_time_f        : $('#start_time_f').val(),
            end_time_f          : $('#end_time_f').val(),
            half_morning_date   : $('#input-form_datetime2').val(),
            start_time_h_m      : $('#start_time_h_m').val(),
            end_time_h_m        : $('#end_time_h_m').val(),
            start_time_h_a      : $('#start_time_h_a').val(),
            end_time_h_a        : $('#end_time_h_a').val(),
            half_afternoon_date : $('#input-form_datetime3').val(),
            start_time_hour     : $('#start_time_hour').val(),
            end_time_hour       : $('#end_time_hour').val(),
            reason_leave        : $('#edit-input-reason-leave-reason').val(),
            approvers           : $('#approved-id').val(),
            total_num_f         : diff_full,
            total_num_m_a       : diff_half_m_a,
            total_num_hour      : diff_leave_hour,
        },
        success: function(response){
            var data_resp = jQuery.parseJSON(response);
            if(data_resp.status == "success"){
                Swal.fire({
                    title: 'บันทึกข้อมูลได้',
                    text: "",
                    type: 'success',
                })
            }else if(data_resp.status == "failed"){
                Swal.fire({
                    title: 'บันทึกข้อมูลไม่ได้',
                    text: 'กรุณาตรวจสอบข้อมูล',
                    type: 'error',
                })

            }
        },
        error: function(errors){
            console.log(errors);
        },
    })
}

function search_data_tbl() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[4];
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