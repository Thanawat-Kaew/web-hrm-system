msg_waiting()

$(document).ready(function(){

	$('.glyphicon-log-out-logout').click(function(){
		confirm_logout();
	})

	$('.logout').click(function(){
		confirm_logout();
	})

})

function confirm_logout(){

	Swal.fire({
		title: 'ต้องการออกจากระบบใช่หรือไม่?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่, ออกเดี๋ยวนี้!',
		cancelButtonText: 'ไม่'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				headers : {'X-CSRF-TOKEN': $('input[name=_token').attr('value')},
				type    : 'POST',
				url     : $('#logout-form').data('url'),
			});
			
			const Toast = Swal.mixin({
				toast: true,
				position: 'body',
				showConfirmButton: false,
				timer: 1500,
				onOpen: (toast) => {
				    toast.addEventListener('mouseenter', Swal.stopTimer)
				    toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})
			Toast.fire({
			  	type: 'success',
			  	title: 'ออกจากระบบสำเร็จ',
			  	customClass: 'largeWidth'
			}).then((result) => {
				window.location.href = 'http://hrm.system.io/logout';
			})
		}
	})
}

function confirm(){
	Swal.fire({
		title: 'Are you sure?',
		text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.value) {
			Swal.fire(
				'Deleted!',
				'Your file has been deleted.',
				'success'
				)
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

function msg_close(){
	Swal.close();
}

function msg_success(){
	Swal.fire({
		type: 'success',
		title: 'Data has been saved',
		showConfirmButton: false,
		timer: 1500
	})
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