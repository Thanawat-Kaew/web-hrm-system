<?php

namespace App\Services\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = 'menu';

	public function employeemenu()
	{
		return $this->hasMany("App\Services\Employee\EmployeeMenu", 'id', 'id_menu'); // id ของ menu // id_menu ของ employee_menu //เอาของ model ตัวเองอยู่ข้างหน้า
	}
}