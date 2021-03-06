<?php

namespace App\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Position\Position;
use App\Services\Department\Department;
use App\Services\Forms\FormEvaluation;
use App\Services\Evaluation\CreateEvaluation;
use App\Services\Evaluation\Part;
use App\Services\Evaluation\Question;
use App\Services\Evaluation\AnswerFormat;
use App\Services\Employee\EmployeeObject;
use App\Services\Evaluation\AnswerDetails;
use App\Services\Evaluation\Evaluation;
use App\Services\Evaluation\ResultEvaluation;
use App\Services\Forms\FormViewEvaluation;
use App\Services\Forms\FormViewCreateEvaluations;
use App\Services\Forms\FormSetTimeEvaluation;
use App\Services\Forms\FormCheckCountEvaluationEmployee;
use App\Services\Forms\FormEmail;
use Illuminate\Support\Facades\Mail;


class EvaluationController extends Controller
{
    public function index()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $department = $current_employee->id_department;

        if($current_employee['id_position'] == 2){ // หัวหน้า
            $evaluations    = CreateEvaluation::where('status', 1)->get(); // status 1 เป็นการยืนยันว่่าผ่านการตรวจสอบ
            //sd($evaluations->toArray());
            //sd($evaluations->count());

            $count_evaluations = $evaluations->count(); // นับจำนวนหัวเรื่องที่ได้ยืนยันสำหรับการประเมิน
            $array_id_topic    = []; // เก็บ array หัวเรื่อง
            $num = 0; // เอาไว้เก็บว่ามีกี่เรื่อง
            for($i=0; $i<$count_evaluations; $i++){
                $array_id_topic[] = $evaluations[$i]['id_topic'];
                $num = $num + 1;
            }
            //sd($num);
            //sd($array_id_topic->toArray());
            //sd($array_id_topic);

            $emp            = Employee::where('id_department', $department)->where('id_position', 1)
                            ->where('id_status', 1)->get(); // เลือกพนักงานทั้งหมดที่ตรงกับแผนก // เลือกเฉพาะลูกน้อง
            //sd($emp->toArray());
            $count_emp      = $emp->count(); // นับจำนวนว่ามีกี่คน ของ $emp
            //sd($count_emp);
            $emp_eva        = Evaluation::with(['employee' => function($q) use($department){
                                    $q->where('id_department', $department);
                                }])->get();
            //sd($emp_eva->toArray());
            $count_emp_eva  = $emp_eva->count(); // นับจำนวนว่ามีกี่คน ของ $emp_eva

            $check_emp_eva = []; // เก็บ array พนักงานที่ประเมินแล้วตามหัวเรื่อง
            for($i=0; $i<$num; $i++){ // for loop ตามจำนวนหัวเรื่องที่ได้รับอนุญาติให้ประเมิน
                $no = 0; // เอาไว้นับจำนวนถ้า หัวเรื่องประเมินตรงกับพนักงานที่มีหัวเรื่องประเมินตรงกัน
                for($j=0; $j<$count_emp_eva; $j++){ // for loop ตามจำนวนหนักงานใน evaluation
                    if(!empty($emp_eva[$j]->employee)){
                    // เช็คว่าพนักงานคนนั้นว่า ตาราง employee ไม่ว่าง ถ้าว่างแสดงว่าแผนกไม่ตรงกับ dareatment ที่เรากำหนด
                        if($array_id_topic[$i] == $emp_eva[$j]->id_topic){ //ถ้า หัวเรื่องที่ได้รับอนุญาติตรงกับหัวเรื่องของพนักงาน
                            $no = $no +1; // ก็ให้บวก 1
                            $check_emp_eva["$i"] = $no; // แล้วแยกเก็บตาม array ของ หัวเรื่องที่ได้รับอนุญาติให้ประเมิน
                        }
                    }
                }
            }


            return $this->useTemplate('evaluation.index', compact('evaluations', 'current_employee', 'department', 'check_emp_eva', 'count_emp'));
        }else if($current_employee['id_position'] == 1){ // ลูกน้อง
            $evaluations = CreateEvaluation::where('id_employee', $current_employee['id_employee'])->where('confirm_send_create_evaluation', 0)->get();
            //sd($evaluations->toArray());
            return $this->useTemplate('evaluation.confirm_send_create_evaluations',compact('current_employee','evaluations'));
        }
    }

    public function sendEmail(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $data           = $request->all();
        $name_sender    = $data['name_sender'];
        $email_sender   = $data['email_sender'];
        $name_reciver   = $data['name_reciver'];
        $email_reciver  = $data['email_reciver'];
        $topic          = $data['topic'];
        $details        = $data['details'];
        //d($name_reciver);
        //sd($data);

        $data = array('name'=>"$name_reciver", "body"=>"$details", 'email_reciver'=>"$email_reciver",
                    'email_sender'=>"$email_sender", 'name_sender'=>"$name_sender", 'topic'=>"$topic");
        //sd($data);
        Mail::send('mail', $data, function($message) use($data){
                $message->to($data['email_reciver'])
                ->subject($data['topic']);
                $message->from($data['email_reciver'], $data['name_sender']);
        });
        return json_encode(['status' => 'success', 'message' => 'success']);
    }

    public function confirmSendCreateEvaluation() //หน้า confirmSendCreateEvaluation
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $evaluations = CreateEvaluation::where('id_employee', $current_employee['id_employee'])->where('confirm_send_create_evaluation', 0)->get();
        return $this->useTemplate('evaluation.confirm_send_create_evaluations',compact('current_employee','evaluations'));
    }

    public function check_count_eval_emp() //หน้าเช็คว่าหัวหน้าประเมินพนักงานครบทุกคนหรือยัง
    {
        $topic_data  = CreateEvaluation::where('status', 1)->where('confirm_send_create_evaluation', 1)->get();
        //sd($topic_data->toArray());
        return $this->useTemplate('evaluation.check_count_evaluations_emp', compact('topic_data'));
    }

    public function postConfirmSendCreateEvaluation(Request $request) // เครื่องหมายติ๊กถูก
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }
        $id                     = $request->get('id');
        //sd($id);
        $find_id_topic          = CreateEvaluation::where('id_topic', $id)->first();
        if($current_employee['id_position'] == 2){
            $find_id_topic->status                         = 1;
            $find_id_topic->confirm_send_create_evaluation = 1;
        }
        $find_id_topic->confirm_send_create_evaluation     = 1;
        $find_id_topic->save();

    }

    public function viewCreateEvaluationRequest() // หน้าการอนุมัติ/ไม่อนุมัติการประเมิน //หัวหน้า HR เท่านั้นที่เข้าได้
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $evaluations = CreateEvaluation::with('employee', 'parts')->where('confirm_send_create_evaluation', 1)->get();
        return $this->useTemplate('evaluation.create_evaluations_request', compact('evaluations'));
    }

    public function viewHistoryCreateEvaluation()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $create_evaluation = CreateEvaluation::where('id_employee', $current_employee->id_employee)
                            ->where('confirm_send_create_evaluation', 1)
                            ->get();
        //$count             = $create_evaluation->part->count();
        //sd($create_evaluation->toArray());
        //sd($pag->toArray());
        //sd($create_evaluation->count());
        return $this->useTemplate('evaluation.history_create_evaluations', compact('current_employee','create_evaluation', 'count'));
    }

    public function create_evaluations()
    {
        $id_new_evaluation  = \Session::has('id_evaluation') ? \Session::get('id_evaluation') : '';
        $check_data         = CreateEvaluation::with('parts')->where('id_topic', $id_new_evaluation)->first();
        $answer_type        = AnswerFormat::all();
        if(!empty($id_new_evaluation)){
            return $this->useTemplate('evaluation.create_evaluations', compact('id_new_evaluation', 'check_data', 'answer_type'));
        }

        $obj_emp                     = new EmployeeObject;
        $employee_id                 = $obj_emp->getIdEmployee();
        $new_evaluation              = New CreateEvaluation;
        $new_evaluation->id_employee = $employee_id;
        $new_evaluation->save();
        $id_new_evaluation           = $new_evaluation->id_topic;
        \Session::put('id_evaluation', $id_new_evaluation);


        return $this->useTemplate('evaluation.create_evaluations', compact('id_new_evaluation'));
    }

    public function postAddEvaluations(Request $request) // กดบันทึกเมื่อสร้างแบบประเมินเสร็จแล่ว
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $department     = $current_employee->id_department;
        //sd($department);
        $evaluations    = CreateEvaluation::where('status', 1)->get(); // status 1 เป็นการยืนยันว่่าผ่านการตรวจสอบ

        $data                                = $request->all();
        $create_evaluation                   = CreateEvaluation::where('id_topic', $data['id_topic'])->first();
        $create_evaluation->topic_name       = $data['name-evaluation-'.$data['id_topic'].''];
        $create_evaluation->years            = date("Y-m-d");
        $create_evaluation->id_answer_format = $data['type_answer-'.$data['id_evaluation'].''];
        $create_evaluation->status           = 2;
        $create_evaluation->save();

        if(isset($data['chapter'])){ // ตรวจสอบว่ามีตอนไหม
            $count_chapter = $data['chapter'] + 1;
            $non = 0;
            for($c_p=1; $c_p<$count_chapter; $c_p++){
                $non += $data['percent-'.$data['id_evaluation'].'-'.$c_p];
            }

            for($i=1; $i < $count_chapter ; $i++){
                $parts                      = Part::where('id_topic', $data['id_topic'])->where('chapter', $i)->first();
                $parts->part_name           = $data['name-parts-'.$data['id_evaluation'].'-'.$i];
                //$parts->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].'-'.$i];
                $parts->percent             = $data['percent-'.$data['id_evaluation'].'-'.$i];
                $parts->save();

                $total_question = $data['total-question-'.$data['id_evaluation'].'-'.$i];
                if($total_question > 1){
                    $count_total_question = $total_question + 1;
                    $count_number_order   = 1;
                    for($j=1; $j < $count_total_question; $j++){
                        //$question                   = new Question;
                        if(isset($data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0])){
                            $question                   = new Question;
                            $question->question_name    = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                            $question->id_part          = $parts['id_part'];
                            //$question->number_order     = $j;
                            $question->number_order     = $count_number_order;
                            $question->save();
                            $count_number_order++;
                        }
                        //$question->question_name    = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                        //$question->id_part          = $parts['id_part'];
                        //$question->number_order     = $j;
                        //$question->save();
                    }
                }else{
                    $question                       = new Question;
                    $question->question_name        = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                    $question->id_part              = $parts['id_part'];
                    $question->number_order         = 1;
                    $question->save();
                }
            }
        }

        \Session::flash('message', 'ทำการสร้างแบบประเมินชื่อ '.$create_evaluation->topic_name .' เรียบร้อยแล้ว');
        return redirect()->route('evaluation.index.get');

    }

    public function assessment(Request $request, $id, $id_topic)
    {
        $id_assessor_person          = $id;
        $id_evaluation               = $id_topic;
        //sd($id_evaluation);
        //sd($id_assessor_person);
        $data_assessor_person        = Employee::with('department', 'position')->where('id_employee', $id_assessor_person)->first();
        //sd($data_assessor_person->toArray());
        //$data_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_evaluation)->first();

        $data_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_evaluation)->first();

        //sd($data_evaluation->toArray());
        //sd($data_evaluation->toArray());
        //sd($data_evaluation->parts[1]->question->count());
        //sd($data_evaluation->parts->count());
        //$value_desc                  = AnswerDetails::with()->orderBy('value', 'DESC')->get();
        return view('evaluation.assessment', compact('data_assessor_person', 'data_evaluation'));
    }

    public function human_assessment(Request $request, $id) //หน้าเช็คสถานะว่าใครยังไม่ได้ถูกประเมิน
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $evaluations = CreateEvaluation::where('status', 1)->get();
        //sd($current_employee->id_department);
        $id_topic                = $id; // รหัสหัวเรื่อง
        //sd($id_topic);
        //sd($id_assessor);
        $id_topic    = CreateEvaluation::with('employee')->where('id_topic', $id_topic)->first(); // ไป query หัวเรื่องนั้นมา
        //sd($id_topic->toArray());
        //sd($id_topic->employee->id_department);
        //$list_name   = Employee::where('id_department', $current_employee->id_department)->where('id_position', '1')->get();
        //sd($list_name->toArray());
        //$list_name_evaluation = Evaluation::get();
        $list_name = Employee::with('evaluation_hasmany')->where('id_department', $current_employee->id_department)->where('id_position', '1')->where('id_status', 1)->get(); // เอารายชื่อพนักงานมา
        //sd($list_name->toArray());
        //$list_name = Employee::with('evaluation')->where('id_department', $current_employee->id_department)->where('id_position', '1')->get();
        //$list_name = Evaluation::with('employee')->get();
        //$list_name = Evaluation::get();
        //sd($list_name->toArray());
        //sd($list_name->count());
        //sd($list_name[0]->evaluation_hasmany->count());
        /*if($list_name[]->evaluation_hasmany->count() > 0){
            echo "ไม่ว่าง";
        }else{
            echo "ว่าง";
        }exit();*/
        //echo $list_name[5]->id_employee."<br>";
        //exit();
        $count_list_name = $list_name->count();
        $array_list_name = []; // เก็บ id_employee ที่ตรงกับ id_topic
        for($i=0; $i<$count_list_name; $i++){
            if($list_name[$i]->evaluation_hasmany->count() > 0){
                //echo "id_employee=".$list_name[$i]->id_employee."<br>";
                $count_eva_has = $list_name[$i]->evaluation_hasmany->count();
                for($j=0; $j<$count_eva_has; $j++){
                    //echo $list_name[$i]->evaluation_hasmany[$j]->id_evaluation."<br>";
                    //echo $list_name[$i]->evaluation_hasmany[$j]->id_topic."<br>";
                    if($list_name[$i]->evaluation_hasmany[$j]->id_topic == $id_topic->id_topic){
                        //echo "id_assessor=".$list_name[$i]->evaluation_hasmany[$j]->id_assessor."<br>";
                        //echo "id_topic=".$list_name[$i]->evaluation_hasmany[$j]->id_topic."<br>";
                        $array_list_name[] = $list_name[$i]->evaluation_hasmany[$j]->id_assessor;
                    }
                }
                //sd($array_list_name);
                //echo "--------------------------------<br>";
            }
        }//var_dump($array_list_name);
        $count_array_list_name = count($array_list_name);
        //sd($count_array_list_name);
        $keep_array_list_name  = [];
        for($i=0; $i<$count_array_list_name; $i++){
            $name_assessor_finish  = Employee::where('id_employee', $array_list_name[$i])->first();
            //echo $name_assessor_finish->id_employee."<br>";

            $keep_array_list_name[] = $name_assessor_finish;
        }//exit();
        /*for($i=0; $i<$count_list_name; $i++){*/
            /*if(in_array($list_name[0]->id_employee, $keep_array_list_name[0])){
                echo "1";
                echo "<br>";
            }exit();*/
        /*}exit();*/
        //sd($name_assessor_finish->toArray());
        //exit();//sd($count_eva_has);
        /*foreach ($list_name as $value) {
            if(isset($value->evaluation_hasmany)){
                echo "ประเมินแล้ว".$value->evaluation_hasmany->id_employee;
            }else{
                echo "ยังไม่ได้ประเมิน".$value->evaluation_hasmany->id_employee;
            }
        }*/
        //sd($list_name->toArray());
        /*$list_name   = Evaluation::with(['employee' => function($q) use($current_employee){
                        $q->where('id_department', $current_employee->id_department);
                        $q->where('id_position', '1');
                        }])->get();*/
        //$list_name     = Employee::with('evaluation')->get();
        //sd($list_name->toArray());
        //$count_list_name = $list_name->count();
        //$check_evaluation = [];
        //print_r($check_evaluation);
        //exit();
        /*for($i=0; $i<$count_list_name; $i++){
            $check_evaluation[] = Evaluation::with('result_evaluation')->where('id_employee', $list_name[$i]->id_employee)->get();
        }*/
        //sd($check_evaluation->toArray());
        //$check_evaluation = Evaluation::with('resultevaluation')->where('id_evaluation', "6")->get();
        //sd($check_evaluation->toArray());
        //$check_evaluation = Evaluation::with('result_evaluation')->where()
        //$check_evaluation = ResultEvaluation::all();
        //print_r($check_evaluation['id_employee']);
        //var_dump($check_evaluation['id_employee']);
        //echo "<br>";
        //exit();
        //sd($check_evaluation);

        return $this->useTemplate('evaluation.human_assessment', compact('list_name', 'id_topic', 'count_array_list_name', 'keep_array_list_name','current_employee'));
    }

    public function editAssessment(Request $request, $id, $id_topic)
    {
        $id_assessor_person          = $id;  //id ผู้ถูกประเมิน
        $id_evaluation               = $id_topic; //id_topic (id หัวเรื่อง)
        //sd($id_evaluation);
        //sd($id_assessor_person);
        $data_assessor_person        = Employee::with('department', 'position')->where('id_employee', $id_assessor_person)->first();
        //sd($data_assessor_person->toArray());
        //$data_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_evaluation)->first();

        $data_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_evaluation)->first();

        $details_evaluation          = Evaluation::with('resultevaluation')->where('id_assessor', $id_assessor_person)->where('id_topic', $id_evaluation)->first();
        //sd($details_evaluation->toArray());

        //sd($data_evaluation->toArray());
        //sd($data_evaluation->toArray());
        //sd($data_evaluation->parts[1]->question->count());
        //sd($data_evaluation->parts->count());
        //$value_desc                  = AnswerDetails::with()->orderBy('value', 'DESC')->get();
        return view('evaluation.edit_assessment', compact('data_assessor_person', 'data_evaluation', 'details_evaluation'));
    }

    public function viewCreateEvaluation(Request $request, $id)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id_topic                = $id;
        $view_create_evaluation  = CreateEvaluation::with('parts', 'parts.question', 'answerformat')->where('id_topic', $id_topic )->first();
        //sd($view_create_evaluation->toArray());
        //sd($view_create_evaluation->parts->toArray());
        //sd(count($view_create_evaluation->parts->toArray()));
        //sd($id);

        //sd($view_id);
        //$id             = $request->get('id');
        //sd($id);
        //return response()->json(['status'=> 'success']);
        //redirect('cre')
        return view('evaluation.view_create_evaluations', compact('view_create_evaluation'));
        // return view('evaluation.view_create_evaluations_for_index', compact('view_create_evaluation'));
        //echo "555";
    }

    public function viewCreateEvaluation_2(Request $request, $id)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id_topic                = $id;
        $view_create_evaluation  = CreateEvaluation::with('parts', 'parts.question', 'answerformat')->where('id_topic', $id_topic )->first();
        return view('evaluation.view_create_evaluations_for_index', compact('view_create_evaluation'));
    }


    public function editEvaluation(Request $request, $id)
    {
        $id_topic           = $id;
        $edit_evaluation    = CreateEvaluation::with('parts', 'parts.question', 'answerformat')->where('id_topic', $id_topic )->first();
        $answer_type        = AnswerFormat::all();
        return $this->useTemplate('evaluation.edit_evaluations', compact('edit_evaluation', 'answer_type'));

    }



     public function postEditEvaluations(Request $request)
    {
        $data                          = $request->all();
        //sd($data);
        $create_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'answerformat')->where('id_topic', $data['id_evaluation'])->first();
        //sd($create_evaluation->toArray());
        $find_count_part               = $create_evaluation->parts->count();
        if($create_evaluation->topic_name  !== $data['name-evaluation-'.$data['id_evaluation'].'']){ // กรณีเขียนหัวเรื่องใหม่
            $create_evaluation->topic_name = $data['name-evaluation-'.$data['id_evaluation'].''];
            $create_evaluation->years      = date("Y-m-d");
            //$create_evaluation->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].''];
            $create_evaluation->save();
        }

        if($create_evaluation->id_answer_format  !== $data['type_answer-'.$data['id_evaluation'].'']){ //กรณีเปลี่ยนรูปแบบคำตอบ
            $create_evaluation->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].''];
             $create_evaluation->save();
        }
        $check_chapter = 0;
        $index_parts   = 0;
        $parts_number  = 0;
        if(isset($data['chapter'])){ // ตรวจสอบว่ามีตอนไหม
            $count_chapter = $data['chapter'] + 1;
            for($i=1; $i < $count_chapter ; $i++){
                $parts                      = Part::where('id_topic', $data['id_evaluation'])->where('chapter', $i)->first();
                $parts->part_name           = $data['name-parts-'.$data['id_evaluation'].'-'.$i];
                //$parts->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].'-'.$i];
                $parts->percent             = $data['percent-'.$data['id_evaluation'].'-'.$i];
                $parts->save();

                $total_question       = $data['total-question-'.$data['id_evaluation'].'-'.$i];
                $count_total_question = $total_question + 1;

                if($total_question > 1){ // กรณีมีมากกว่า 1 คำถาม
                    if($data['total-question-'.$data['id_evaluation'].'-'.$i] > $create_evaluation->parts[$parts_number]->question->count()){
                        $question_number = 0;
                        for($j=1; $j < $count_total_question; $j++){
                            if(isset($data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0])){
                                if(isset($create_evaluation->parts[$parts_number]->question[$question_number]->question_name)){
                                    if($data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0] == $create_evaluation->parts[$parts_number]->question[$question_number]->question_name){
                                        echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                                        echo "<br>";
                                        echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$parts_number]->question[$question_number]->question_name;
                                        echo "<br>";
                                        echo "มีมากว่า 1 คำถาม";
                                        echo "<br>";
                                        echo "input ไม่เท่าเดิม";
                                        echo "<br>";
                                        echo "ค่าใน input ไม่มีการเปลี่ยนแปลง";
                                        echo "<br>";
                                        echo "มีใน Database";
                                        echo "<br>";
                                        echo "--------------------------";
                                        echo "<br>";
                                    }else{
                                        $edit_question = Question::where('id_question', $create_evaluation->parts[$parts_number]->question[$question_number]->id_question)->first();
                                        $edit_question->question_name = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                                        $edit_question->save();
                                        echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                                        echo "<br>";
                                        echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$parts_number]->question[$question_number]->question_name;
                                        echo "<br>";
                                        echo "มีมากว่า 1 คำถาม";
                                        echo "<br>";
                                        echo "input ไม่เท่าเดิม";
                                        echo "<br>";
                                        echo "ค่าใน input มีการเปลี่ยนแปลง";
                                        echo "<br>";
                                        echo "มีใน Database";
                                        echo "<br>";
                                        echo "--------------------------";
                                        echo "<br>";
                                    }
                                }else{ //create กรณีเพิ่ม input จากของเดิม
                                    $question                       = new Question;
                                    $question->question_name        = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                                    $question->id_part              = $parts['id_part'];
                                    $question->save();
                                    $find_question                  = Question::where('id_part', $parts['id_part'])->get();
                                    $count_find_question            = $find_question->count();
                                    $question->number_order         = $count_find_question++;
                                    $question->save();
                                    echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0];
                                    echo "<br>";
                                    echo "มีมากว่า 1 คำถาม";
                                    echo "<br>";
                                    echo "input ไม่เท่าเดิม";
                                    echo "<br>";
                                    echo "สร้างคำถามใหม่";
                                    echo "<br>";
                                    echo "ไม่มีใน Database";
                                    echo "<br>";
                                    echo "--------------------------";
                                    echo "<br>";
                                }
                                $question_number++;
                            }
                        }$parts_number++;
                    }else{ // input เท่าเดิม
                        for($j=1; $j < $count_total_question; $j++){
                            if(isset($data['name-question-'.$data['id_evaluation'].'-'.$i.'-'.$j][0])){
                                if($check_chapter < $data['chapter']){
                                    $num_part = 1;
                                    for($p=0; $p < $find_count_part; $p++){
                                        $find_count_question = $create_evaluation->parts[$p]->question->count(); //มาจากฐานช้อมูล
                                        $num_question = 1;
                                        for($q=0; $q < $find_count_question; $q++){
                                            if(isset($data['name-question-'.$data['id_evaluation'].'-'.$num_part.'-'.$num_question][0])){
                                                if($data['name-question-'.$data['id_evaluation'].'-'.$num_part.'-'.$num_question][0] !== $create_evaluation->parts[$p]->question[$q]->question_name){
                                                    $edit_question = Question::where('id_question', $create_evaluation->parts[$p]->question[$q]->id_question)->first();
                                                    $edit_question->question_name = $data['name-question-'.$data['id_evaluation'].'-'.$num_part.'-'.$num_question][0];
                                                    $edit_question->save();
                                                    echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$num_part.'-'.$num_question][0];
                                                    echo "<br>";
                                                    echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$p]->question[$q]->question_name;
                                                    echo "<br>";
                                                    echo "มีมากว่า 1 คำถาม";
                                                    echo "<br>";
                                                    echo "input เท่าเดิม";
                                                    echo "<br>";
                                                    echo "ค่าใน input มีการเปลี่ยนแปลง";
                                                    echo "<br>";
                                                    echo "มีใน Database";
                                                    echo "<br>";
                                                    echo "--------------------------";
                                                    echo "<br>";
                                                }else{
                                                    echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$num_part.'-'.$num_question][0];
                                                    echo "<br>";
                                                    echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$p]->question[$q]->question_name;
                                                    echo "<br>";
                                                    echo "มีมากว่า 1 คำถาม";
                                                    echo "<br>";
                                                    echo "input เท่าเดิม";
                                                    echo "<br>";
                                                    echo "ค่าใน input ไม่มีการเปลี่ยนแปลง";
                                                    echo "<br>";
                                                    echo "มีใน Database";
                                                    echo "<br>";
                                                    echo "--------------------------";
                                                    echo "<br>";
                                                }
                                            }
                                            $num_question++;
                                        }
                                        $num_part++;
                                    }
                                }
                                $check_chapter++;
                            }
                        }
                    }
                    $parts_number++;
                }else{ // คำถามเท่ากับ 1
                    if(isset($create_evaluation->parts[$index_parts]->question[0]->question_name)){
                        if(isset($data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0])){
                            if($data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0] == $create_evaluation->parts[$index_parts]->question[0]->question_name){
                                echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                                echo "<br>";
                                echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$index_parts]->question[0]->question_name;
                                echo "<br>";
                                echo "มี 1 คำถาม";
                                echo "<br>";
                                echo "ค่าใน input ไม่มีการเปลี่ยนแปลง";
                                echo "<br>";
                                echo "มีใน Database";
                                echo "<br>";
                                echo "--------------------------";
                                echo "<br>";
                            }else{ //แก้ไขข้อความใน input
                                $h1 = Question::where('id_question', $create_evaluation->parts[$index_parts]->question[0]->id_question)->first();
                                //sd($h1->toArray());
                                //sd($h1->toArray());
                                $f1 = Part::with('question')->where('id_part' , $create_evaluation->parts[$index_parts]->id_part)->get();
                                $f1[0]['question'][0]->question_name = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                                $f1[0]['question'][0]->save();
                                echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                                echo "<br>";
                                echo "ข้อมูลจากฐานข้อมูล =".$create_evaluation->parts[$index_parts]->question[0]->question_name;
                                echo "<br>";
                                echo "มี 1 คำถาม";
                                echo "<br>";
                                echo "ค่าใน input มีการเปลี่ยนแปลง";
                                echo "<br>";
                                echo "มีใน Database";
                                echo "<br>";
                                echo "--------------------------";
                                echo "<br>";
                            }
                        }
                    }else{ // กรณีไม่มีในฐานข้อมูล
                        if(isset($data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0])){
                            $question                       = new Question;
                            $question->question_name        = $data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                            $question->id_part              = $parts['id_part'];
                            $question->number_order         = 1;
                            $question->save();
                            echo "ข้อมูลที่ input เข้ามา = ".$data['name-question-'.$data['id_evaluation'].'-'.$i.'-1'][0];
                            echo "<br>";
                            echo "มี 1 คำถาม";
                            echo "<br>";
                            echo "ไม่มีใน Database";
                            echo "<br>";
                            echo "สร้างคำถามใหม่";
                            echo "<br>";
                            echo "--------------------------";
                            echo "<br>";
                        }
                    }
                    $index_parts++;
                }
            }
        }

         \Session::flash('message', 'ทำการแก้ไขแบบประเมิน '.$data['input-assess_fullname']. ' เรียบร้อยแล้ว');
        return redirect()->route('evaluation.confirm_send_create_evaluations.get');
    }

    public function postRecordEvaluation(Request $request) // กดบันทึกผลเมื่อประเมินเสร็จแล้ว
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        //sd($current_employee->id_employee);
        $from_the_full_score                = 0;
        $data                               = $request->all();
        // d($data);

        $evaluation                         = new Evaluation;
        $evaluation->id_topic               = $data['id_topic'];
        $evaluation->id_assessor            = $data['id_assessor_person'];
        // d($evaluation->id_assessor);
        $evaluation->id_assessment_person   = $current_employee->id_employee;
        // d($evaluation->id_assessment_person);

        $evaluation->result_evaluation      = $data['total-evluation'];
        // d($evaluation->result_evaluation);
        $evaluation->date                   = date("Y-m-d");
        // sd($evaluation->date);
        $evaluation->save();

        $find_id_evaluation                 = Evaluation::where('id_assessor', $data['id_assessor_person'])->where('id_assessment_person', $current_employee->id_employee)->where('result_evaluation', $data['total-evluation'])->where('id_topic',$data['id_topic'])->where('date', date("Y-m-d"))->first();
        // d($find_id_evaluation->toArray());

        for($i=0; $i<$data['total-part']; $i++){
            for($j=0; $j<$data['count-question-'.$i]; $j++){
                $result_evaluation                  = new ResultEvaluation;
                $result_evaluation->id_evaluation   = $find_id_evaluation['id_evaluation'];
                $result_evaluation->id_part         = $data['id_part-'.$i];
                $result_evaluation->id_question     = $data['id_question-'.$i.'-'.$j];
                $result_evaluation->answer          = $data['total-question-'.$i.'-'.$j];
                $result_evaluation->percent_of_part = $data['percent-'.$i];
                $result_evaluation->status          = 1;
                $result_evaluation->save();
                $from_the_full_score++;

            }
        }
        $find_answer_format                 = CreateEvaluation::with('answerformat', 'answerformat.answerdetails')
                                            ->where('id_topic', $data['id_topic'])
                                            ->first(); // ค้นหาจำนวนรุปแบบคำตอบชองหัวข้อการประเมินนี้
        $count_answer_format                = $find_answer_format->answerformat->answerdetails->count();

        $find_evaluation     = Evaluation::where('id_evaluation', $find_id_evaluation['id_evaluation'])->first();
        //sd($find_evaluation);
        $find_evaluation->from_the_full_score = $from_the_full_score * $count_answer_format;
        $find_evaluation->percent             = ($data['total-evluation'] * 100) / ($from_the_full_score * $count_answer_format);
        $find_evaluation->save();
        //sd($evaluations);
        //sd($no);
        //$result_evaluation->

        \Session::flash('message', 'ทำการประเมินคุณ '.$data['input-assess_fullname'].' เรียบร้อยแล้ว');
        return redirect()->route('evaluation.human_assessment.get', $data['id_topic']);

    }


    public function postEditRecordEvaluation(Request $request) // กดบันทึกผลเมื่อแก้ไขการลงคะแนนการประเมิน
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        //sd($current_employee->id_employee);
        $from_the_full_score                = 0;
        $data                               = $request->all();
       // d($data);
        $evaluation                         = Evaluation::where('id_evaluation', $data['id_evaluation'])->first(); //ค้นหา id การประเมิน เพื่อจะเ update ผลรวม
        //d($evaluation->toArray());
        $evaluation->id_assessment_person   = $current_employee['id_employee'];
        $evaluation->result_evaluation      = $data['total-evluation'];
        $evaluation->save();

        /*$find_id_evaluation                 = Evaluation::where('id_assessor', $data['id_assessor_person'])->where('id_assessment_person', $current_employee->id_employee)->where('result_evaluation', $data['total-evluation'])->where('date', date("Y-m-d"))->first();*/
        //sd($find_id_evaluation['id_evaluation']);
        //$count_question = 0;
        //$get_answer     = [];
        for($i=0; $i<$data['total-part']; $i++){ // นับจำนวนตอน
            for($j=0; $j<$data['count-question-'.$i]; $j++){ //นับจำนวนคำถามต่อตอน
                //$get_answer[] = $data['total-question-'.$i.'-'.$j];
                $result_evaluation          = ResultEvaluation::where('id_evaluation', $data['id_evaluation'])
                                              ->where('id_part', $data['id_part-'.$i])
                                              ->where('id_question', $data['id_question-'.$i.'-'.$j])
                                              ->first();
                //d($result_evaluation->toArray());
                $result_evaluation->answer  = $data['total-question-'.$i.'-'.$j];
                $result_evaluation->save();
                /*$result_evaluation->id_evaluation   = $find_id_evaluation['id_evaluation'];
                $result_evaluation->id_part         = $data['id_part-'.$i];
                $result_evaluation->id_question     = $data['id_question-'.$i.'-'.$j];
                $result_evaluation->answer          = $data['total-question-'.$i.'-'.$j];
                $result_evaluation->percent_of_part = $data['percent-'.$i];
                $result_evaluation->status          = 1;
                $result_evaluation->save();*/
                $from_the_full_score++;
                //$count_question++; // นับจำนวนคำถาม
            }
        }
        //exit();
        //sd($get_answer[0]);
        //sd($result_evaluation[1]->answer);
        //$result_evaluation   = ResultEvaluation::where('id_evaluation', $data['id_evaluation'])->get();
        //for($k=0; $k<$count_question; $k++){
            //$result_evaluation[$i]->answer = 1;//$get_answer[$i];
           // $result_evaluation->save();
       //}
        //$result_evaluation->answer = 1;
        //exit();
        $find_answer_format                 = CreateEvaluation::with('answerformat', 'answerformat.answerdetails')
                                            ->where('id_topic', $data['id_topic'])
                                            ->first(); // ค้นหาจำนวนรุปแบบคำตอบชองหัวข้อการประเมินนี้
        $count_answer_format                = $find_answer_format->answerformat->answerdetails->count();

        $find_evaluation     = Evaluation::where('id_evaluation', $data['id_evaluation'])->first();
        //sd($find_evaluation);
        $find_evaluation->from_the_full_score = $from_the_full_score * $count_answer_format;
        $find_evaluation->percent             = ($data['total-evluation'] * 100) / ($from_the_full_score * $count_answer_format);
        $find_evaluation->save();

        // sd($fine_evaluations);
        //sd($no);
        //$result_evaluation->
         \Session::flash('message', 'ทำการแก้ไขการประเมินคุณ '.$data['input-assess_fullname']. ' เรียบร้อยแล้ว');
        return redirect()->route('evaluation.human_assessment.get', $data['id_topic']);
        //return view('evaluation.view_create_evaluations', compact('view_create_evaluation'));
        //sd($data);
    }

    public function confirmCreateEvaluation(Request $request) //อนุมัติการ create evaluation
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }
        $id                     = $request->get('id');
        $confirm                = CreateEvaluation::find($id);
        $confirm->status        = 1;
        $confirm->id_approve    = $current_employee->id_employee;
        $confirm->save();
    }

    public function cancelCreateEvaluation(Request $request) //ไม่อนุมัติการ create evaluation
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }
        $id                     = $request->get('id');
        $confirm                = CreateEvaluation::find($id);
        $confirm->status        = 3;
        $confirm->id_approve    = $current_employee->id_employee;
        $confirm->save();
    }


    public function setStartDateAndEndDateEvaluation(Request $request) //บันทึกกำหนดวันเริ่มต้นประเมินและสิ้นสุดประเมิน
    {
        $data                               = $request->all();
        $id_topic                           = CreateEvaluation::where('id_topic', $data['id_topic'])->first();
        $id_topic->start_date_evaluation    = $data['start_date'];
        $id_topic->end_date_evaluation      = $data['end_date'];
        $id_topic->save();
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getFormEvaluation':

                $id_evaluation       = $request->get('id_evaluation');
                //sd($id_evaluation);
                $find_part           = CreateEvaluation::with('parts')->where('id_topic', $id_evaluation)->first();
                if(empty($find_part)){
                    return response()->json(['status'=> 'error','data'=> "None fault evaluation"]);
                }
                $form_repo       = new FormEvaluation;
                $part            = new Part;
                $answer_type     = AnswerFormat::all();
                $part->id_topic  = $id_evaluation;
                $total_parts     = $find_part->parts->count();
                $part->chapter   = $total_parts+1;
                $part->save();

                $form_evaluation = $form_repo->getFormEvaluation($id_evaluation, $part, $answer_type);

                return response()->json(['status'=> 'success','data'=> $form_evaluation]);
                break;

            case 'getFormSetTimeEvaluation': // กำหนดเวลาการประเมิน
                $id_topic                  = $request->get('id_topic');
                $check_set_date_evaluation = CreateEvaluation::where('id_topic', $id_topic)->first();
                //sd($check_set_date_evaluation->toArray());
                $form_repo       = new FormSetTimeEvaluation;
                $form_set_time_eval = $form_repo->getFormSetTimeEvaluation($id_topic, $check_set_date_evaluation);

                return response()->json(['status'=> 'success','data'=> $form_set_time_eval]);
                break;

            case 'getFormViewCreateEvaluations':

                if(\Session::has('current_employee')){
                    $current_employee = \Session::get('current_employee');
                }
                $id_topic                = $request->get('id');
                // sd($id_topic);
                $view_create_evaluation  = CreateEvaluation::with('parts', 'parts.question', 'answerformat')->where('id_topic', $id_topic )->first();

                $form_repo       = new FormViewCreateEvaluations;
                $form_view_create_eval = $form_repo->getFormViewCreateEvaluations($view_create_evaluation);

                return response()->json(['status'=> 'success','data'=> $form_view_create_eval]);
                break;

            case 'createNewEvaluation':

                $obj_emp                        = new EmployeeObject;
                $employee_id                    = $obj_emp->getIdEmployee();
                $new_evaluation                 = New CreateEvaluation;
                $new_evaluation->id_employee    = $employee_id;
                $new_evaluation->save();

                $id_new_evaluation              = $new_evaluation->id_topic;
                \Session::put('id_evaluation', $id_new_evaluation);

                return response()->json(['status'=> 'success']);
                break;

            case 'view':

                $id      = $request->get('id');
                //sd($id);
                return response()->json(['status'=> 'success', 'data' => $id]);
                break;

            case 'deleteQuestion':
                $id          = $request->get('id');
                //sd($id);
                $id_question = Question::where('id_question', $id)->first();
                //sd($id);
                $id_question->delete();
                return response()->json(['status'=> 'success', 'data' => $id]);
                break;

            case 'deleteParts':
                $id          = $request->get('id');
                //sd($id);
                $id_part     = Part::with('question')->where('id_part', $id)->first();
                //sd($id);
                //sd($id_question->toArray());
                $id_part->delete();
                return response()->json(['status'=> 'success', 'data' => $id]);
                break;

            case 'deleteCreateEvaluation':
                $id          = $request->get('id');
                //sd($id);
                $id_topic    = CreateEvaluation::with('parts', 'parts.question')->where('id_topic', $id)->first();
                //sd($id_question->toArray());
                $id_topic->delete();
                return response()->json(['status'=> 'success', 'data' => $id]);
                break;

            case 'viewEvaluation': // ดูการประเมิน ที่ลงคะแนนแล้ว
                $id_employee  = $request->get('id_employee');
                //sd($id_employee);
                $id_topic     = $request->get('id_topic');

                $evaluation_data    = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_topic)->first();
                //sd($evaluation_data->answerformat->answerdetails->count());
                //sd($evaluation_data->toArray());
                $evaluation_details = Evaluation::with('resultevaluation')->where('id_assessor', $id_employee)->where('id_topic', $id_topic)->first();
                $form_repo           = new FormViewEvaluation;
                $get_form_view_eva   = $form_repo->getFormViewEvaluation($evaluation_data, $evaluation_details);
                return response()->json(['status'=> 'success','data'=> $get_form_view_eva]);
                break;

            case 'getFormCheckCountEvaluationEmployee': // Form แสดงผลจำนวนคนที่ถูกประเมินตามแต่ละแผนกและหัวข้อ
                $id_topic            = $request->get('id_topic'); // รับ id_topic มา
                $department          = Department::all();
                $count_department    = $department->count(); // นับจำนวน department ว่ามีเท่าไร

                $employee = [];
                for($i=0; $i<$count_department; $i++){
                    $employee[]         = Employee::with('department')->where('id_department', $department[$i]->id_department)->where('id_position', 1)->where('id_status', 1)->get(); // เก็บข้อมูลพนักงานแยกเป็นแผนก // เก๋บเฉพาะลูกน้อง
                }

                $count_by_department    = []; // เก็บจำนวนคนที่ประเมินแล้วแยกตามแผนก
                $count_emp              = 0;// นับพนักงานที่ประเมินแล้วตามหัวเรื่องนั้นๆ
                $emp_evaluation         = Evaluation::with('employee')
                                        ->where('id_topic', $id_topic)
                                        ->get();

                $count_emp_evaluation   = $emp_evaluation->count(); // นับจำนวนพนักงานที่ตรงกับหัวเรื่องประเมิน
                for($i=0; $i<$count_department; $i++){ // for loop ตามจำนวน แผนก
                    for($j=0; $j<$count_emp_evaluation; $j++){ // for loop ตามจำนวนพนักงานที่ประเมินแล้วและหัวข้อตรงกับ id_topic
                        if($emp_evaluation[$j]->employee->id_department == $department[$i]->id_department){
                            $count_emp = $count_emp + 1; // ถ้า แผนกตรงกันก็ให้บวก+1 ไปเรื่อยๆตามจำนวนที่ตรงกัน
                            $count_by_department["$i"] = $count_emp;  // แล้วเก็บจำนวนแยกตามแผนก
                        }
                    }
                    $count_emp = 0; // reset ทุกครั่งที่เปลี่ยนแผนก
                }

                $form_repo           = new FormCheckCountEvaluationEmployee; // ชื่อ page
                $get_form_view_eva   = $form_repo->getFormCheckCountEvaluationEmployee($department, $employee, $count_by_department); // ชื่อ function ใน page
                return response()->json(['status'=> 'success','data'=> $get_form_view_eva]);
                break;

            case 'getFormEmail': // Form กรอกข้อมูลของ email
                $id_department = $request->get('id_department');
                $reciver       = Employee::where('id_department', $id_department)->where('id_position', 2)->first();
                //sd($reciver->toArray());
                //sd($id_department);
                $form_repo     = new FormEmail;
                $get_form      = $form_repo->getFormEmail($reciver);
                return response()->json(['status'=> 'success','data'=> $get_form]);
                break;

            default:
                # code...
                break;
        }
    }

    public function postDeleteCreateEvaluation($id) // กบลบการประเมินที่หน้า evaluation/index.php
    {
        $id_topic    = CreateEvaluation::with('parts', 'parts.question', 'evaluation', 'evaluation.resultevaluation')->where('id_topic', $id)->first();
        //sd($id_topic->toArray());
        //d($id_topic->toArray());
        if(!empty($id_topic)){ // ถ้า หัวเรื่องมีจริง
            if($id_topic->parts->count() > 0){ // ถ้า part มากกว่า 0 แสดงว่าการประเมินนี้มีตอน
                $count_part      = $id_topic->parts->count(); // นับจำนวน part ของ หัวเรื่องการประเมินที่ลบ

                $get_id_part     = []; // ตัวแปรที่เอาไว้เก็บ id ของ part แต่ละ part

                for($i=0; $i<$count_part; $i++){ // loop ตามจำนวนตอนที่การประเมินมี
                    $id_part        = Part::where('id_topic', $id_topic->parts[$i]->id_topic)->get();
                    $get_id_part[]  = $id_part[$i]->id_part; // เก็บ id ของแต่ละตอน
                }

                $get_id_question = []; // ตัวแปรที่เอาไว้เก็บ id ของ คำถาม แต่ละของแต่ละตอน
                $count_question  = []; // ตัวแปรที่เก็บเอาไว้นับ จำนวนตอนต่อคำถาม
                $check_question  = false; // เช็ค question มามีจริงไหม
                for($j=0; $j<$count_part; $j++){ // loop ตามจำนวนตอน
                    $id_part        = Part::with('question')->where('id_part', $get_id_part[$j])->first();
                    // หา id_part ตาม id ที่เก็บไว้ในตัวแปร $get_id_part
                    $count_question[$j]  = $id_part->question->count(); // นับจำนวนคำถามต่อตอน
                    if($count_question[$j] > 0){ //ถ้ามากกว่า 0 แสดงว่ามี คำถาม
                        $check_question  = true;
                        for($k=0; $k<$count_question[$j]; $k++){ // loop ตามจำนวนคำถาม
                            $get_id_question[$j][$k] =  $id_part->question[$k]->id_question; //ทำการแยกใส่ array ว่าตอนนนี้มีกี่คำถาม
                        }
                    }
                    $id_part->delete(); // ลบตอน
                }
                if($check_question){ // check ว่ามีคำภามไหม
                    for($i=0; $i<$count_part; $i++){ // loop ตามจำนวนตอน
                        for($j=0; $j<$count_question[$i]; $j++){ // loop ตามจำนวนคำถามต่อตอน
                            $id_question = Question::where('id_question', $get_id_question[$i][$j])->first();
                            $id_question->delete(); // ลบคำถาม
                        }
                    }
                }
            }

            if($id_topic->evaluation->count() > 0){ // ถ้ามากกว่า 0 แสดงว่ามีการประเมินแล้ว
                $count_evaluation     = $id_topic->evaluation->count(); // นับจำนวน การประเมิน ของ หัวเรื่องการประเมินที่ลบ เช่นการประเมินนี้ประเมินไปแล้ว 2 คน ก็จะนับได้ 2
                $get_id_evaluation    = []; // ตัวแปรที่เอาไว้เก็บ id ของการประเมินที่ลงคะนนการปเมินแล้ว

                for($i=0; $i<$count_evaluation; $i++){ // loop ตามจำนวนตอนที่มีการประเมิน
                    $id_evaluation       = Evaluation::where('id_topic', $id_topic->evaluation[$i]->id_topic)->get();
                    $get_id_evaluation[] = $id_evaluation[$i]->id_evaluation; // เก็บ id ของแต่ละการประเมิน
                }


                $get_id_result_eva = []; // ตัวแปรที่เอาไว้เก็บ id ของรายละเอียดการประเมิน
                $count_result_eva  = []; // ตัวแปรที่เก็บเอาไว้นับ จำนวนรายละเอียดของการประเมิน
                $check_result_eva = false;
                for($i=0; $i<$count_evaluation; $i++){ // loop ตามจำนวนที่มีการลงคะแนนประเมิน
                    $id_evaluation      = Evaluation::with('resultevaluation')
                                        ->where('id_evaluation', $get_id_evaluation[$i])
                                        ->first(); // หา id_evaluation ตาม id ที่เก็บไว้ในตัวแปร $get_id_evaluation
                    $count_result_eva[$i]  = $id_evaluation->resultevaluation->count(); // นับจำนวนรายละเอียดคำตอบต่อการประเมิน
                    if($count_result_eva[$i] > 0){ //ถ้ามากกว่า 0 แสดงว่ามีรายละเอียดคำตอบ
                        $check_result_eva  = true;
                        for($j=0; $j<$count_result_eva[$i]; $j++){ // loop ตามจำนวนรายละเอียด
                            $get_id_result_eva[$i][$j] =  $id_evaluation->resultevaluation[$j]->id_result_evaluation; //ทำการแยกใส่ array id ของ ลายละเอียดคำตอบ
                        }
                    }
                    $id_evaluation->delete(); // ลบการประเมิน
                }

                if($check_result_eva){ // ถ้ามีราลละเอียดการประเมิน
                    for($i=0; $i<$count_evaluation; $i++){ // loop ตามจำนวนการประเมิน
                        for($j=0; $j<$count_result_eva[$i]; $j++){ // loop ตามจำนวนรายละเอียดต่อการประเมิน
                            $id_result_eva = ResultEvaluation::where('id_result_evaluation', $get_id_result_eva[$i][$j])->first();
                            $id_result_eva->delete(); // ลบลายละเอียดการประเมิน
                        }
                    }
                }

            }
            $id_topic->delete(); // ลบข้อมูลของ table create_evaluation
            return['status'     => 'success', 'message' => 'Delete complete.'];
        } else {
            return['status'     => 'failed','message'   =>'Not found.'];
        }
    }
}