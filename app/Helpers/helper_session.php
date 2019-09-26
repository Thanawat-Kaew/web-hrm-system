<?php

function helperPutSuccess($message)
{
	$data['status'] 	= 'success';
	$data['message'] 	= $message;
	\Session::flash('flash_alert', $data);
}

function helperPutError($message)
{
	$data['status'] 	= 'error';
	$data['message'] 	= $message;
	\Session::flash('flash_alert', $data);
}

function helperPutEffectTypeToSession($effect)
{
	\Session::put('focus_effect_type', $effect);
}

function helperGetEffectType()
{
	if (\Session::has('focus_effect_type'))
	{
		return \Session::get('focus_effect_type');
	}

	\Session::put('focus_effect_type', 'button_icon');
	return 'button_icon';
}

function helperSetMenuBar($menubar = '')
{
	if ($menubar == '') $menubar = helperGetMenuBarDefault();
	\Session::put('sys_menubar', $menubar);
	return true;
}

function helperGetMenuBarDefault()
{
	$menubar = 'unfold';
	return $menubar;
}

function helperGetMenuBar()
{
	if (!\Session::has('sys_menubar')) helperSetMenuBar();
	return \Session::get('sys_menubar');
}