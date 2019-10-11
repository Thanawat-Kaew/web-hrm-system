<?php namespace App\Services\Employee;

use App\Services\Employee\Employee; // floder\file name
use App\Services\Department\Department; // floder\file name

class EmployeeObject{
	protected $id_department;
    protected $id_position;
    protected $id_employee;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $address;
    protected $gender;
    protected $tel;
    protected $age;
    protected $education;
    protected $salary;
    protected $id_role;

    public function __construct()
	{
		// Put Session to Object.
		if (\Session::has('current_employee')) {

			$current_employee 	  = \Session::get('current_employee');
			$this->id_employee    = $current_employee->id_employee;
			$this->id_department  = $current_employee->id_department;
			$this->id_position 	  = $current_employee->id_position;
			$this->first_name	  = $current_employee->first_name;
			$this->last_name	  = $current_employee->last_name;
			$this->email		  = $current_employee->email;
			$this->password		  = $current_employee->password;
			$this->address		  = $current_employee->address;
			$this->gender 		  = $current_employee->gender;
			$this->tel	          = $current_employee->tel;
			$this->age		      = $current_employee->age;
			$this->education	  = $current_employee->education;
			$this->salary		  = $current_employee->salary;
			$this->id_role		  = $current_employee->id_role;
		}
	}
	public function setUp($checkLogin)
	{
		// Save to Session.
        \Session::put('current_employee', $checkLogin);
    }

    public function setupMenu($id_employee)
    {
    	$current_menu = Employee::with('employeemenu', 'employeemenu.menu')->where('id_employee', $id_employee)->first();
    	// sd($this->id_employee);
    	$menu = []; //array
    	if(!empty($current_menu->employeemenu)){
    		foreach ($current_menu->employeemenu as $key => $value) {
                //sd($value);
    			$submenu = [];
    			$submenu['name_th'] = $value->menu->name_th;
    			$submenu['name_en'] = $value->menu->name_en;
    			$submenu['permission'] = $value->permission;
    			$submenu['sorting'] = $value->menu->sorting;
    			$submenu['image'] = $value->menu->image;
    			$submenu['route'] = $value->menu->route;
                //$submenu['email'] = $value->employee->email;

    			$menu[] = (object)$submenu;
    			//d($value->menu->toArray());
    		}
    	}

    	\Session::put('current_menu', (object)$menu);
        //$curr_emp =
        // sd((object)$menu);
    }

    public function getIdEmployee()
    {
    	return $this->id_employee;
    }

    public function getEmail()
    {
    	return $this->email;
    }

    public function getFirstName()
    {
    	return $this->first_name;
    }

    public function getLastName()
    {
    	return $this->last_name;
    }

    public function getIdPosition()
    {
        return $this->id_position;
    }

    public function getIdDepartment()
    {
        return $this->id_department;
    }

    public function mockMenu()
    {
    	return ["id_employee" => "", "permission" =>  "", "menu" => [] ];
    }

}