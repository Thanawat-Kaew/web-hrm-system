    <div class="container">
        <section class="content">
            <h1>ลงเวลา</h1>
            <div class="row">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">TimeStamp</h3>
                    </div>
                    <div class="box-body">
                        <div class="clock">
                            <div id="Date"></div>
                            <ul class="clock">
                                <li id="hours"> </li>
                                <li id="point">:</li>
                                <li id="min"> </li>
                                <li id="point">:</li>
                                <li id="sec"> </li>
                            </ul>
                        </div> 
                        <div class="input-group name_employee">
                            <div class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                            <input class="form-control" type="text" readonly value=" ธนวัฒน์  แก้วล้อมวัง">
                        </div><br>
                        <div class="input-group password_employee">
                            <div class="input-group-addon">
                                <i class="fa fa-unlock"></i>
                            </div>
                            <input class="form-control" type="password" placeholder="Enter your password..." value="">
                        </div><br>
                        <div class="form-group ">
                            <label>รูปแบบ</label>
                            <select class="form-control select2" style="width: 100%;">
                                <option selected="selected" value="time_in" id="time_in">ลงเวลาเข้า  (Time In)</option>
                                <option value="time_out"  id="time_out">ลงเวลาออก  (Time Out)</option>
                                <option value="break_out" id="break_out">ออกพักกลางวัน  (Break Out)</option>
                                <option value="break_in"  id="break_in">เข้าพักกลางวัน  (Break In)</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <a href="">
                                <button class="btn btn-info pull-center add_time_stamp" type="submit">SUBMIT</button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box box-body table-responsive no-padding">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Time-In</th>
                            <th>Break-In</th>
                            <th>Break-Out</th>
                            <th>Time-Out</th>
                        </tr>
                        <tr>
                            <td>ธนวัฒน์ แก้วล้อมวัง</td>
                            <td>Web Developer</td>
                            <td>11-7-2014</td>
                            <td>09:00</td>
                            <td>-</td>
                            <td>-</td>
                            <td>18:00</td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
    </div>
