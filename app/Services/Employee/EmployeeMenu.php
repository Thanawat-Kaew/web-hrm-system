<?php

namespace App\Services\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeMenu extends Model
{
	protected $table = 'employee_menu';

	public function employee()
	{
		return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
	}

	public function menu()
	{
		return $this->belongsTo("App\Services\Menu\Menu", 'id_menu', 'id'); // เอาของ model ของตัวเองอยู่ข้างหน้า
	}
}