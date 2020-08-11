<?php

function setLang($lang = '')
{
	$all = getLangAll();

	if (!in_array($lang, $all) || $lang == '')
	{
		$lang = getLangDefault();
	}

	//\App::setLocale($lang);
	\Session::put('sys_lang', $lang);

	return true;
}

function getLang()
{
	if (!\Session::has('sys_lang'))
	{
		setLang();
	}

	return \Session::get('sys_lang');
}

function getLangAll()
{
	$lang = config('app.langs');
	return $lang;
}

function getLangDefault()
{
	$langs = getLangAll();
	$first = $langs[0];
	return $first;
}