<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEmail
{
	public static function getFormEmail($reciver)
	{
		$form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="" id="id_employee">';
                    $form .= 'ชื่อผู้ส่ง';
                    $form .= '<div class="input-group name_sender">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="text" value=""  placeholder="ชื่อผู้ส่ง" id="name_sender">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="name_sender-text-error"></label><br>';

                    $form .= 'อีเมล์ผู้ส่ง';
                    $form .= '<div class="input-group email_sender">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-envelope-o"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="email" value=""  placeholder="simple@example.com" id="email_sender">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="email_sender-text-error"></label><br>';

                    $form .= 'ชื่อผู้รับ';
                    $form .= '<div class="input-group name_reciver">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="text" value=""  placeholder="ชื่อผู้รับ" id="name_reciver">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="name_reciver-text-error"></label><br>';

                    $form .= 'อีเมล์ผู้รับ';
                    $form .= '<div class="input-group email_reciver">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-envelope-o"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="email" value=""  placeholder="simple@example.com" id="email_reciver">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="email_reciver-text-error"></label><br>';

                    $form .= 'หัวข้อ';
                    $form .= '<div class="input-group topic">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-header"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="text" value=""  placeholder="Please type the header" id="topic">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="topic-text-error"></label><br>';

                    $form .= 'เนื้อหา';
                    $form .= '<div class="input-group details">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-file-text-o"></i>';
                        $form .= '</div>';
                        $form .= '<textarea class="form-control required " type="text" value=""  placeholder="please type the details" id="details" rows="4" cols="50">';
                        $form .= '</textarea>';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="details-text-error"></label>';

                $form .= '</div>';
            $form .= '</div>';
        $form .= '</div>';
        return $form;
	}

}

?>