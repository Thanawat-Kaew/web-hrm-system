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

class EvaluationController extends Controller
{
	public function index()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        if($current_employee['id_position'] == 2){ // หัวหน้า
            $evaluations = CreateEvaluation::where('status', 1)->get();
            //sd($evaluations->toArray());
            return $this->useTemplate('evaluation.index', compact('evaluations', 'current_employee'));
        }else if($current_employee['id_position'] == 1){ // ลูกน้อง
            $evaluations = CreateEvaluation::where('id_employee', $current_employee['id_employee'])->where('confirm_send_create_evaluation', 0)->get();
            //sd($evaluations->toArray());
            return $this->useTemplate('evaluation.confirm_send_create_evaluations',compact('current_employee','evaluations'));
        }
    }

    public function confirmSendCreateEvaluation() //หน้า confirmSendCreateEvaluation
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $evaluations = CreateEvaluation::where('id_employee', $current_employee['id_employee'])->where('confirm_send_create_evaluation', 0)->get();
        return $this->useTemplate('evaluation.confirm_send_create_evaluations',compact('current_employee','evaluations'));
    }

    public function postConfirmSendCreateEvaluation(Request $request) // เครื่องหมายติ๊กถูก
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }
        $id                     = $request->get('id');
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
        $create_evaluation = CreateEvaluation::where('id_employee', $current_employee->id_employee)->paginate(10);
        //$count             = $create_evaluation->part->count();
        //sd($create_evaluation->toArray());
        $pag               = CreateEvaluation::paginate(10);
        //sd($pag->toArray());
        //sd($create_evaluation->count());
        return $this->useTemplate('evaluation.history_create_evaluations', compact('current_employee','create_evaluation', 'count', 'pag'));
    }

    public function create_evaluations()
    {
        $id_new_evaluation  = \Session::has('id_evaluation') ? \Session::get('id_evaluation') : '';
        $check_data         = CreateEvaluation::with('parts')->where('id_topic', $id_new_evaluation)->first();
        $answer_type        = AnswerFormat::all();
        //sd($check_data->toArray());
        //sd($answer_type->toArray());
        //$check_data  = CreateEvaluation::with('parts', 'parts.answerformat')->where('id_topic', $id_new_evaluation)->first();
        //sd($check_data->parts->toArray());
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

    public function postAddEvaluations(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $data                          = $request->all();
        //sd($data);
        //sd($data['name-question-'.$data['id_evaluation'].'-'.'1'.'-'.'3'][0]);

        //sd($data['id_evaluation']);
        $create_evaluation             = CreateEvaluation::where('id_topic', $data['id_topic'])->first();
        $create_evaluation->topic_name = $data['name-evaluation-'.$data['id_topic'].''];
        $create_evaluation->years      = date("Y-m-d");
        $create_evaluation->status     = 2;
        $create_evaluation->save();

        if(isset($data['chapter'])){ // ตรวจสอบว่ามีตอนไหม
            $count_chapter = $data['chapter'] + 1;
            $non = 0;
            for($c_p=1; $c_p<$count_chapter; $c_p++){
                //echo $data['percent-'.$data['id_evaluation'].'-'.$c_p];
                //echo "<br>";
                $non += $data['percent-'.$data['id_evaluation'].'-'.$c_p];

                //echo "<br>";
            }//echo $non;

            for($i=1; $i < $count_chapter ; $i++){
                $parts                      = Part::where('id_topic', $data['id_topic'])->where('chapter', $i)->first();
                $parts->part_name           = $data['name-parts-'.$data['id_evaluation'].'-'.$i];
                $parts->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].'-'.$i];
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
    }

    public function assessment(Request $request, $id, $id_topic)
    {
        $id_assessor_person          = $id;
        $id_evaluation               = $id_topic;
        //sd($id_evaluation);
        //sd($id_assessor_person);
        $data_assessor_person        = Employee::with('department', 'position')->where('id_employee', $id_assessor_person)->first();
        //sd($data_assessor_person->toArray());
        $data_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat', 'parts.answerformat.answerdetails')->where('id_topic', $id_evaluation)->first();
        //sd($data_evaluation->toArray());
        //sd($data_evaluation->parts[1]->question->count());
        //sd($data_evaluation->parts->count());
        //$value_desc                  = AnswerDetails::with()->orderBy('value', 'DESC')->get();
        return view('evaluation.assessment', compact('data_assessor_person', 'data_evaluation'));
    }

    public function human_assessment(Request $request, $id)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        //sd($current_employee->id_department);
        $id_assessor                = $id; // รหัสหัวเรื่อง
        $id_topic    = CreateEvaluation::with('employee')->where('id_topic', $id_assessor)->first();
        //sd($id_topic->toArray());
        //sd($id_topic->employee->id_department);
        $list_name   = Employee::with('evaluation', 'evaluation.resultevaluation')->where('id_department', $current_employee->id_department)->where('id_position', '1')->get();
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

        return $this->useTemplate('evaluation.human_assessment', compact('list_name', 'id_topic'));
    }

    public function viewCreateEvaluation(Request $request, $id)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id_topic                = $id;
        $view_create_evaluation  = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat')->where('id_topic', $id_topic )->first();
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
        $view_create_evaluation  = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat')->where('id_topic', $id_topic )->first();
        //sd($view_create_evaluation->toArray());
        //sd($view_create_evaluation->parts->toArray());
        //sd(count($view_create_evaluation->parts->toArray()));
        //sd($id);

        //sd($view_id);
        //$id             = $request->get('id');
        //sd($id);
        //return response()->json(['status'=> 'success']);
        //redirect('cre')
        // return view('evaluation.view_create_evaluations', compact('view_create_evaluation'));
        return view('evaluation.view_create_evaluations_for_index', compact('view_create_evaluation'));
        //echo "555";
    }


    public function editEvaluation(Request $request, $id)
    {
        $id_topic           = $id;
        $edit_evaluation    = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat')->where('id_topic', $id_topic )->first();
        //sd($edit_evaluation->toArray());
        //sd($edit_evaluation->parts->toArray());
        //if($edit_evaluation)
        $answer_type        = AnswerFormat::all();
        //sd($answer_type->toArray());
        return $this->useTemplate('evaluation.edit_evaluations', compact('edit_evaluation', 'answer_type'));

    }



     public function postEditEvaluations(Request $request)
    {
        $data                          = $request->all();
        //sd($data);
        $create_evaluation             = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat')->where('id_topic', $data['id_evaluation'])->first();
        $find_count_part               = $create_evaluation->parts->count();
        if($create_evaluation->topic_name  !== $data['name-evaluation-'.$data['id_evaluation'].'']){ // กรณีเขียนหัวเรื่องใหม่
            $create_evaluation->topic_name = $data['name-evaluation-'.$data['id_evaluation'].''];
            $create_evaluation->years      = date("Y-m-d");
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
                $parts->id_answer_format    = $data['type_answer-'.$data['id_evaluation'].'-'.$i];
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
    }

    public function postRecordEvaluation(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        //sd($current_employee->id_employee);
        $data                               = $request->all();
        //sd($data);
        $evaluation                         = new Evaluation;
        $evaluation->id_assessor            = $data['id_assessor_person'];
        $evaluation->id_assessment_person   = $current_employee->id_employee;
        $evaluation->result_evaluation      = $data['total-evluation'];
        $evaluation->date                   = date("Y-m-d");
        $evaluation->save();

        $find_id_evaluation                 = Evaluation::where('id_assessor', $data['id_assessor_person'])->where('id_assessment_person', $current_employee->id_employee)->where('result_evaluation', $data['total-evluation'])->where('date', date("Y-m-d"))->first();
        //sd($find_id_evaluation['id_evaluation']);

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
            }

        }

        //$result_evaluation->

        //return view('evaluation.view_create_evaluations', compact('view_create_evaluation'));
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
                //sd($id_topic->toArray());
                //sd($id_question->toArray());
                $id_topic ->delete();
                return response()->json(['status'=> 'success', 'data' => $id]);
                break;

            default:
                # code...
                break;
        }
    }

    public function postDeleteCreateEvaluation($id)
    {
        $id_topic    = CreateEvaluation::with('parts', 'parts.question')->where('id_topic', $id)->first();

        if(!empty($id_topic)){

            $id_topic->delete();

            return['status'     => 'success', 'message' => 'Delete complete.'];
        } else {
            return['status'     => 'failed','message'   =>'Not found.'];
        }
    }
}