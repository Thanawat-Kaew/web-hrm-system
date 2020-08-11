<?php namespace App\Services\Admin;

use App\Services\Admin\Admin; // floder\file name
//use App\Services\Department\Department; // floder\file name

class AdminObject{
	protected $id_admin;
    protected $user_admin;
    protected $pass_admin;

    public function __construct()
	{
		// Put Session to Object.
		if (\Session::has('current_admin')) {

			$current_admin	      = \Session::get('current_admin');
			$this->id_admin       = $current_admin->id_admin;
			$this->user_admin     = $current_admin->user_admin;
			$this->pass_admin 	  = $current_admin->pass_admin;
		}
	}
	public function setUp($checkLogin)
	{
		// Save to Session.
        \Session::put('current_admin', $checkLogin);
        //sd(\Session::get('current_admin')->toArray());
    }

    /*public function setupMenu($id_employee)
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
                $submenu['fa_icon'] = $value->menu->fa_icon;
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
    }*/
}