$(document).ready(function(){
	$('.dropup-new-record').on('click', '.add-new-record', function(){ // New Record
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getFormNewTimeClock'},
			success: function (result) {
				var title = "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add New Record</small></h4>";
				showDialog(result.data,title)
			},
			error: function(errors){
				console.log(errors)
			}
		})
	})

	$('.time-clock').on('click', '.time_stamp', function(){ //Time Clock
		window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
	});

	$('.timepicker').timepicker()
	$('.datepicker').datepicker({autoclose: true,format: 'dd-mm-yyyy'})
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

	box.on("shown.bs.modal", function() {
		 	// Select picker.
		 	$('.select-hour').on('click', 'li', function(){
		 		$('.select-hour>li').removeClass('selected-hour');
		 		$(this).addClass('selected-hour');
		 	});
		 	$('.select-minutes').on('click', 'li', function(){
		 		$('.select-minutes>li').removeClass('selected-minutes');
		 		$(this).addClass('selected-minutes');
		 	});

		 	// Open time picker custom.
		 	$('#input-time_in').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#input-time_out').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#input-break_in').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#input-break_out').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('.datepicker').datepicker({autoclose: true,format: 'yyyy-mm-dd'})

		// Checkbox add new Record
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass   : 'iradio_flat-green'
		})

		$('#t_in_out').on('ifChecked', function(event){
			$('#t_in').iCheck('enable');
			$('#t_out').iCheck('enable');
		});

		$('#t_in_out').on('ifUnchecked', function(event){
			$('#t_in').iCheck('disable').iCheck('uncheck');
			$('#t_out').iCheck('disable').iCheck('uncheck');
		});

		$('#t_in').on('ifChecked', function(event){
			$('.input-t_in').removeClass('hide')
			$('#input-time_in').addClass('required')
		}).on('ifUnchecked', function(event){
			$('.input-t_in').addClass('hide')
			$('#input-time_in').removeClass('required')
			$('#input-time_in-text-error').html("").hide();
		});

		$('#t_out').on('ifChecked', function(event){
			$('.input-t_out').removeClass('hide')
			$('#input-time_out').addClass('required')
		}).on('ifUnchecked', function(event){
			$('.input-t_out').addClass('hide')
			$('#input-time_out').removeClass('required')
			$('#input-time_out-text-error').html("").hide();

		});

		$('#br_in_out').on('ifChecked', function(event){
			$('#br_in').iCheck('enable');
			$('#br_out').iCheck('enable');
		});

		$('#br_in_out').on('ifUnchecked', function(event){
			$('#br_in').iCheck('disable').iCheck('uncheck');
			$('#br_out').iCheck('disable').iCheck('uncheck');
		});

		$('#br_in').on('ifChecked', function(event){
			$('.input-b_in').removeClass('hide')
			$('#input-break_in').addClass('required')
		}).on('ifUnchecked', function(event){
			$('.input-b_in').addClass('hide')
			$('#input-break_in').removeClass('required')
			$('#input-break_in-text-error').html("").hide();
		});

		$('#br_out').on('ifChecked', function(event){
			$('.input-b_out').removeClass('hide')
			$('#input-break_out').addClass('required')
		}).on('ifUnchecked', function(event){
			$('.input-b_out').addClass('hide')
			$('#input-break_out').removeClass('required')
			$('#input-break_out-text-error').html("").hide();
		});
		// end Checkbox

		$('body').addClass('modal-open');

		if(oldValue !== ""){
			$.each(oldValue, function(key, value) {
				$('#input-'+key).val(value);
				if(value == "") {
					$('#input-'+key + "-text-error").html("* Required").show();
				} else {
					$('#input-'+key + "-text-error").html("").hide();
				}
			});
		}

		if (oldCheck !== "") {
			$.each(oldCheck, function(key, value){
				if (value) {
					$('#'+key).iCheck('check');
					$('#input-'+key).addClass('required');
				}else{
					$('#'+key).iCheck('uncheck')
					$('#input-'+key).removeClass('required');


				}
			})
		}

		if(errors !== ""){
			jQuery.each(errors, function(k, v){
				$('#input-'+k+'-text-error').html(v).show();
			})
		}
	});
};




function sendRequest(form, title){
	msg_waiting();
	var count 			 = 0;
	var oldValue 		 = {};
	jQuery.each($('.required'),function(){
		var name = $(this).attr('name');
		oldValue[name]= $(this).val();
		if ($(this).val() =="") {
			count++
			$(this).css({"border" : "1px solid red"});
		}else{
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
	}else{
		/*if(title == "<h4 style='color: red;'>เพิ่มข้อมูล <small> | Add New Record</small></h4>"){*/
			addRequestTimeStamp(form, title, oldValue,oldCheck);
		/*}else if(title == "<h4 style='color: red;'>แก้ไขข้อมูลการขอลงเวลาย้อนหลัง</h4>"){
			editRequestTimeStamp(form, title, oldValue,oldCheck);
		}*/
	}
}

function addRequestTimeStamp(form, title, oldValue,oldCheck){ // บันทึกลง Table request_time_stamp
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#add-request-time-stamp').data('url'),
		data : {
			request_date  : $('#input-request_timestamp').val(),
			time_in 	  : $('#input-time_in').val(),
			time_out 	  : $('#input-time_out').val(),
			break_out 	  : $('#input-break_in').val(),
			break_in 	  : $('#input-break_out').val(),
			reason 	      : $('#input-reason').val(),
			approvers_id  : $('#approved-id').val(),
		},
		success: function(response){
			var data_resp = jQuery.parseJSON(response);
			if(data_resp.status == "success"){
				// alert("success");
				//alert(response.message);
				//msg_close();
				msg_success();
				//window.location.reload();
			}else{
				// alert("error");
				// alert(response);
				var data_resp = jQuery.parseJSON(response);
				showDialog(form, title, oldValue,oldCheck, data_resp.message);

			}
			// success alert
			//msg_success()
			//alert("success");
			//window.location.reload();
			// alert('Data save');
			// msg_close();
		},
		error: function(errors){
			console.log(errors);
		}
	});
}



function getTimePicker(obj_input)
{
	var str = "";
	str += "<div class='row'>";
	str += "<div class='col-sm-6 col-xs-6'>";
	str += "<label>Hour</label>";
	str += "<ul id='select-hour'  class='select-hour' style='list-style: none;'>";
	str += "<li class='selected-hour'>00</li>";
	str += "<li>01</li>";
	str += "<li>02</li>";
	str += "<li>03</li>";
	str += "<li>04</li>";
	str += "<li>05</li>";
	str += "<li>06</li>";
	str += "<li>07</li>";
	str += "<li>08</li>";
	str += "<li>09</li>";
	str += "<li>10</li>";
	str += "<li>11</li>";
	str += "<li>12</li>";
	str += "<li>13</li>";
	str += "<li>14</li>";
	str += "<li>15</li>";
	str += "<li>16</li>";
	str += "<li>17</li>";
	str += "<li>18</li>";
	str += "<li>19</li>";
	str += "<li>20</li>";
	str += "<li>21</li>";
	str += "<li>22</li>";
	str += "<li>23</li>";
	str += "</ul>";
	str += "</div>";

	str += "<div class='col-sm-6 col-xs-6'>";
	str += "<label>Minutes</label>";
	str += "<ul id='select-minutes' class='select-minutes' style='list-style: none;'>";
	str += "<li class='selected-minutes'>00</li>";
	str += "<li>01</li>";
	str += "<li>02</li>";
	str += "<li>03</li>";
	str += "<li>04</li>";
	str += "<li>05</li>";
	str += "<li>06</li>";
	str += "<li>07</li>";
	str += "<li>08</li>";
	str += "<li>09</li>";
	str += "<li>10</li>";
	str += "<li>11</li>";
	str += "<li>12</li>";
	str += "<li>13</li>";
	str += "<li>14</li>";
	str += "<li>15</li>";
	str += "<li>16</li>";
	str += "<li>17</li>";
	str += "<li>18</li>";
	str += "<li>19</li>";
	str += "<li>20</li>";
	str += "<li>21</li>";
	str += "<li>22</li>";
	str += "<li>23</li>";
	str += "<li>24</li>";
	str += "<li>25</li>";
	str += "<li>26</li>";
	str += "<li>27</li>";
	str += "<li>28</li>";
	str += "<li>29</li>";
	str += "<li>30</li>";
	str += "<li>31</li>";
	str += "<li>32</li>";
	str += "<li>33</li>";
	str += "<li>34</li>";
	str += "<li>35</li>";
	str += "<li>36</li>";
	str += "<li>37</li>";
	str += "<li>38</li>";
	str += "<li>39</li>";
	str += "<li>40</li>";
	str += "<li>41</li>";
	str += "<li>42</li>";
	str += "<li>43</li>";
	str += "<li>44</li>";
	str += "<li>45</li>";
	str += "<li>46</li>";
	str += "<li>47</li>";
	str += "<li>48</li>";
	str += "<li>49</li>";
	str += "<li>50</li>";
	str += "<li>51</li>";
	str += "<li>52</li>";
	str += "<li>53</li>";
	str += "<li>54</li>";
	str += "<li>55</li>";
	str += "<li>56</li>";
	str += "<li>57</li>";
	str += "<li>58</li>";
	str += "<li>59</li>";
	str += "</ul>";
	str += "</div>";
	Swal.fire({
		title: 'เลือกเวลา',
		html: str,
		width: 900,
		showCloseButton: true,
		showCancelButton: true,
		focusConfirm: false,
		allowOutsideClick: false,
		confirmButtonText: 'Save',
		cancelButtonText: 'Cancel',
		onBeforeOpen: () => {
			$('.select-hour').on('click', 'li', function(){
				$('.select-hour>li').removeClass('selected-hour');
				$(this).addClass('selected-hour');
			});
			$('.select-minutes').on('click', 'li', function(){
				$('.select-minutes>li').removeClass('selected-minutes');
				$(this).addClass('selected-minutes');
			});

			var time_ = $(obj_input).val();
			if(time_ !== ""){
				var hh_mm = time_.split(':');
				var hh = hh_mm[0];
				var mm = hh_mm[1];
				jQuery.each($('.select-minutes>li'), function(){
					if(String($(this).text()) == String(mm)){
						$(this).addClass('selected-minutes');
					} else{
						$(this).removeClass('selected-minutes');
					}
				});
				jQuery.each($('.select-hour>li'), function(){
					if(String($(this).text()) == (hh)){
						$(this).addClass('selected-hour');
					} else{
						$(this).removeClass('selected-hour');
					}
				});
			}

		}
	}).then((result) => {
		if (result.value) {
			var hh =  $('.select-hour>li.selected-hour').text();
			var mm = $('.select-minutes>li.selected-minutes').text();
			$(obj_input).val(hh+":"+mm);
		}
	});

}
// $('.time-clock').on('click', '.time_stamp', function(){
// 	window.open('/index/timestamp','_blank','location=yes,left=300,top=30,height=700,width=720,scrollbars=yes,status=yes');
// });

