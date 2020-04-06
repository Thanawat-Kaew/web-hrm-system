  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo route('main.get')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>HR</b>M</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>HR</b>-MANAGEMENT</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
        <?php if(\Session::has('current_employee')){
          $current_employee = \Session::get('current_employee');
          //sd($current_employee->toArray());
          $waiting_status                  = 2;
          $current_id_employee             = $current_employee->id_employee;
          $request_change_data       = $current_employee->with(['requestchangedata' => function($q) use($waiting_status){
                                              $q->where('status', $waiting_status);}])->get();
          //sd($request_change_data->toArray());
          $request_time_stamp        = $current_employee->with(['requesttimestamp' => function($q) use($current_id_employee,
                                                $waiting_status){
                                                  $q->where('approvers', $current_id_employee)->where('status', $waiting_status);
                                                }])->get();
          //sd($request_time_stamp->toArray());
          $request_leave             = $current_employee->with(['leaves' => function($q) use($current_id_employee,
                                                $waiting_status){
                                                  $q->where('approvers', $current_id_employee)->where('status_leave', $waiting_status);
                                                }])->get();
          //sd($request_leave->toArray());
          //sd($request_leave[99]->leaves->count());

          $confirm_create_evaluation  = $current_employee->with(['createevaluation_hasmany' => function($q) use($waiting_status){

                                              $q->where('status', $waiting_status)->where('confirm_send_create_evaluation',1);}])->get();

          //sd($confirm_create_evaluation[93]->createevaluation_hasmany->toArray());
          //sd($confirm_create_evaluation->count());


          $sum_request_change_data    = 0;
          $count_request_change_data  = $request_change_data->count();
          for($i=0; $i<$count_request_change_data; $i++){
            if($request_change_data[$i]->requestchangedata->count() > 0){
              $count_requestchangedata = $request_change_data[$i]->requestchangedata->count();
              if($count_requestchangedata > 1){
                for($j=0; $j<$count_requestchangedata; $j++){
                  $sum_request_change_data = $sum_request_change_data + 1;
                }
              }else{
                $sum_request_change_data = $sum_request_change_data + 1;
              }

            }
          }
          //sd($sum_request_change_data);

          $sum_request_time_stamp     = 0;
          $count_request_time_stamp   = $request_time_stamp->count();
          for($i=0; $i<$count_request_time_stamp; $i++){
            if($request_time_stamp[$i]->requesttimestamp->count() > 0){
              $count_requesttimestamp = $request_time_stamp[$i]->requesttimestamp->count();
              if($count_requesttimestamp > 1){
                for($j=0; $j<$count_requesttimestamp; $j++){
                  $sum_request_time_stamp = $sum_request_time_stamp + 1;
                }
              }else{
                $sum_request_time_stamp = $sum_request_time_stamp + 1;
              }
            }
          }
          //sd($sum_request_time_stamp);

          $sum_request_leave     = 0;
          $count_request_leave  = $request_leave->count();
          for($i=0; $i<$count_request_leave; $i++){
            if($request_leave[$i]->leaves->count() > 0){
              $count_leaves = $request_leave[$i]->leaves->count();
              if($count_leaves > 1){
                for($j=0; $j<$count_leaves; $j++){
                  $sum_request_leave = $sum_request_leave + 1;
                }
              }else{
                $sum_request_leave = $sum_request_leave + 1;
              }
            }
          }
          //sd($sum_request_leave);

          $sum_confirm_create_evaluation   = 0;
          $count_confirm_create_evaluation = $confirm_create_evaluation->count();
          for($i=0; $i<$count_confirm_create_evaluation; $i++) {
            if($confirm_create_evaluation[$i]->createevaluation_hasmany->count() > 1){
              $count_createevaluation = $confirm_create_evaluation[$i]->createevaluation_hasmany->count();
              $sum_confirm_create_evaluation = $sum_confirm_create_evaluation + $count_createevaluation;
            }else if($confirm_create_evaluation[$i]->createevaluation_hasmany->count() > 0){
              $sum_confirm_create_evaluation = $sum_confirm_create_evaluation + 1 ;
            }
          }
          //sd($sum_confirm_create_evaluation);

          /*$sum_confirm_create_evaluation   = 0;
          $count_confirm_create_evaluation = $confirm_create_evaluation->count();
          for($i=0; $i<$count_confirm_create_evaluation; $i++){
            if($confirm_create_evaluation[$i]->createevaluation_hasmany->count() > 0){
              $count_createevaluation = $confirm_create_evaluation[$i]->createevaluation_hasmany->count();
              if($count_createevaluation > 1){
                for($j=0; $j<$count_createevaluation; $j++){
                  $sum_confirm_create_evaluation = $sum_confirm_create_evaluation + 1;
                }
              }else{
                $sum_confirm_create_evaluation = $sum_confirm_create_evaluation + 1;
              }
            }
          }
          sd($sum_confirm_create_evaluation);*/
          if($current_employee['id_department'] == "hr0001"){
            $sum_request = $sum_request_change_data + $sum_request_time_stamp + $sum_request_leave + $sum_confirm_create_evaluation;
          }else{
            $sum_request = $sum_request_time_stamp + $sum_request_leave;
          }
          if($current_employee['id_position'] == 2){
        ?>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle <?php //echo ($sum_request == 0 ? 'hide' : '')?>" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning "><?php echo ($sum_request == 0 ? '' : $sum_request)?></span>
            </a>
            <ul class="dropdown-menu" style="width: 350px;">
              <li class="header">คุณมี <?php echo $sum_request;?> การแจ้งเตือน</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php if($current_employee['id_department'] == "hr0001"):?>
                  <li class="view-amendment">
                    <a href="<?php echo route('data_management.notification_request.get')?>">
                      <i class="fa fa-users text-aqua"></i> รายการคำร้องขอเปลี่ยนแปลงข้อมูลส่วนตัว
                      <span class="label label-warning"><?php echo ($sum_request_change_data == 0 ? '' : $sum_request_change_data)?></span>
                    </a>
                  </li>
                  <?php endif ?>
                  <li class="view-time-stamp-request">
                    <a href="<?php echo route('time_stamp.time_stamp_request.get')?>">
                      <i class="fa fa-clock-o text-aqua"></i> รายการคำร้องขอลงเวลาย้อนหลัง
                    <span class="label label-warning"><?php echo ($sum_request_time_stamp == 0 ? '' : $sum_request_time_stamp)?></span>
                    </a>
                  </li>
                  <li class="view-request-leave">
                    <a href="<?php echo route('leave.leave_request.get');?>">
                      <i class="fa fa-calendar-o text-aqua"></i> รายการคำร้องขอลา
                      <span class="label label-warning"><?php echo ($sum_request_leave == 0 ? '' : $sum_request_leave)?></span>
                    </a>
                  </li>
                  <?php if($current_employee['id_department'] == "hr0001"):?>
                  <li class="view-request-create-evaluation">
                    <a href="<?php echo route('evaluation.create_evaluations_request.get')?>">
                      <i class="fa fa-clipboard text-aqua"></i>รายการขออนุมัติสร้างแบบประเมิน
                      <span class="label label-warning"><?php echo ($sum_confirm_create_evaluation == 0 ? '' : $sum_confirm_create_evaluation)?></span>
                    </a>
                  </li>
                  <?php endif ?>
                </ul>
              </li>
            </ul>
          </li>
        <?php } /*End if id_postion = 2*/
        } ?> <!-- End if session  -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a>
            <?php if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee');
                if(!empty($current_employee->image)){?> <!-- ถ้ามีรูป  -->
                  <img src="/public/image/<?php echo $current_employee->image ?>" class="user-image img-circle" alt="User Image" style="width: 30px; height: 30px;">
                <?php }else{?> <!-- ถ้าไม่มีรุป -->
                  <img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                <?php } ?> <!-- End if image -->
            <?php } ?> <!-- End of Session -->

            <?php if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee'); ?>
                <span class="hidden-xs"><?php echo $current_employee['first_name']; ?> <?php echo $current_employee['last_name']; ?></span>
            <?php }else if(\Session::has('current_admin')){
                $current_admin = \Session::get('current_admin'); ?>
                <span class="hidden-xs"><?php echo $current_admin['user_admin']; ?></span>
            <?php  } ?>
            </a>
            </li>
              <div class="pull-right">
                <a href="#" class=""><span class="glyphicon glyphicon-log-out glyphicon-log-out-logout" style="font-size: 30px;
                margin-top: 6px; color: white; margin-right: 10px;"></span></a>
              </div>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>

        </nav>
      </header>
      <!-- data -->
<div id="logout-form" data-url="<?php echo route('logout.index.post') ?>"></div>
<?php echo csrf_field() ?>