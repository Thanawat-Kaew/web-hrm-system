$(document).ready(function(){

	$('#myTable').dataTable({
		stateSave : true
	});

	$('.table').on('click','.view-request-timestamp',function(){	
			var	id = $(this).data('id');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {'method' : 'getViewRequestTimeStamp',
			'id'	: id
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูล <small> | Edit Employee</small></h4>"
				bootbox.dialog({
					title: title,
					message: result.data,
					size: 'small',
					onEscape: true,
					backdrop: 'static',
					buttons: {
						fum: {
							label: 'ปิด',
							className: 'btn-warning',
							callback: function(){
							}
						}
					}
				})
				msg_close();
			},
			error : function(errors)
			{
				console.log(errors);
			}
		})
	});

	$('.table').on('click','.edit-data-request-timestamp',function(){	
		//alert("edit");
		var	id = $(this).data('id');
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
			type: 'POST',
			url: $('#ajax-center-url').data('url'),
			data: {method : 'getEditRequestTimeStamp',
			'id'    : id,
			},
			success: function (result) {
				var title = "<h4 style='color: red;'>แก้ไขข้อมูลการขอลงเวลาย้อนหลัง</h4>";
				showEditDialog(result.data,title)
			},
			error: function(errors){
				console.log(errors)
			}
		})
	});

	$('.table').on('click','.delete-data',function(){	
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
});

function showEditDialog(form,title,oldValue='',oldCheck='',errors=''){
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
		 	$('#edit-input-t_in').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#edit-input-t_out').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#edit-input-b_in').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('#edit-input-b_out').on('click', function(){
		 		getTimePicker($(this));
		 	});

		 	$('.datepicker').datepicker({autoclose: true,format: 'yyyy-mm-dd'})

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
		 });
};


function sendRequest(form, title){
	msg_waiting();
	var count 			 = 0;
	var oldValue 		 = {};
	jQuery.each($('.required'),function(){
		var name = $(this).attr('id');
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
		showEditDialog(form, title, oldValue,oldCheck);
	}else{
		editRequestTimeStamp(form, title, oldValue,oldCheck);
	}
}



function editRequestTimeStamp(oldValue){ // แก้ไข request_time_stamp
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type : 'POST',
		url  : $('#edit-request-time-stamp').data('url'),
		data : {
			id            : $('#id-edit-request-timestamp').val(),
			request_date  : $('#edit-date-request-timestamp').val(),
			time_in 	  : $('#edit-input-t_in').val(),
			time_out 	  : $('#edit-input-t_out').val(),
			break_out 	  : $('#edit-input-b_in').val(), // ออกไปพัก
			break_in 	  : $('#edit-input-b_out').val(),// เขาทำงานหลังพัก
			reason 	      : $('#edit-reason-request-time-stamp').val(),
			approvers_id  : $('#approved-id-edit').val(),
		},

		success: function(response){

			if(response.status == "failed_t_in_ts"){
				//alert("ไม่สามารถลง time_in เพราะมีวันที่และ time_in อยู่ใน timestamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "เข้าทำงาน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "failed_b_out_ts"){
				//alert("ไม่สามารถลง break_out เพราะมีวันที่และ break_out อยู่ใน timestamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "พักกลางวัน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "failed_b_in_ts"){
				//alert("ไม่สามารถลง break_in เพราะมีวันที่และ break_in อยู่ใน timestamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "เข้าทำงานช่วงบ่าย" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "failed_t_out_ts"){
				//alert("ไม่สามารถลง time_out เพราะมีวันที่และ time_out อยู่ใน timestamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "ออกงาน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "success_timein"){
				//alert("แก้ไขการลงเวลา time_in สำเร็จ");
				Swal.fire({
					title: 'แก้ไขการลงเวลา "เข้าทำงาน" สำเร็จ',
					text: "",
					type: 'success',
				})
			}else if(response.status == "failed_t_in_q"){
				//alert("ไม่สามารถลงเวลา time_in ได้ เพราะมีวันที่และ time_in อยู่ใน request_time_stamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "เข้าทำงาน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "success_breakout"){
				//alert("แก้ไขการลงเวลา break_out สำเร็จ");
				Swal.fire({
					title: 'แก้ไขการลงเวลา "พักกลางวัน" สำเร็จ',
					text: "",
					type: 'success',
				})
			}else if(response.status == "failed_b_out_q"){
				//alert("ไม่สามารถลงเวลา break_out ได้ เพราะมีวันที่และ break_out อยู่ใน request_time_stamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "พักกลางวัน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "success_breakin"){
				//alert("แก้ไขการลงเวลา break_in สำเร็จ");
				Swal.fire({
					title: 'แก้ไขการลงเวลา "เข้าทำงานช่วงบ่าย" สำเร็จ',
					text: "",
					type: 'success',
				})
			}else if(response.status == "failed_b_in_q"){
				//alert("ไม่สามารถลงเวลา break_in ได้ เพราะมีวันที่และ break_in อยู่ใน request_time_stamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "เข้าทำงานช่วงบ่าย" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')

			}else if(response.status == "success_timeout"){
				//alert("แก้ไขการลงเวลา time_out สำเร็จ");
				Swal.fire({
					title: 'แก้ไขการลงเวลา "ออกงาน" สำเร็จ',
					text: "",
					type: 'success',
				})
			}else if(response.status == "failed_b_out_q"){
				//alert("ไม่สามารถลงเวลา time_out ได้ เพราะมีวันที่และ time_out อยู่ใน request_time_stamp");
				Swal.fire(
					'ไม่สามารถแก้ไขการลงเวลา "ออกงาน" ได้!','เนื่องจากมีการแก้ไขข้อมูลนี้ในระบบแล้ว','error')
			}

		},
		error: function(error){
			alert('Edit data not save to request time stamp');
			msg_close();
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

function postDelete(url)
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
		type: "POST",
		url: url,
		success: function(result)
		{
			if(result.status == "success")
			{
				Swal.fire(
				{
					title: 'คุณลบรายการนี้เรียบร้อย',
					type: 'success',
					showCancelButton: false,
					confirmButtonText: 'ปิด'

				}).then((result) =>{

					if (result.value)
					{
						window.location.reload();
					}
				})

			}
			else
			{
				alert(result.message);
			}
		},
		error : function(errors)
		{
			console.log(errors);
		}
	});
}