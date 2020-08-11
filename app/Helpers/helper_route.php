<?php

function helperGetRoute()
{
	return Route::currentRouteName();
}

function helperGetModule()
{
	$route = explode('.', helperGetRoute());
	return isset($route[0]) ? $route[0] : '';
}

function helperGetAction()
{
	$route = explode('.', helperGetRoute());
	return isset($route[1]) ? $route[1] : '';
}

function helperGetMethod()
{
	$route = explode('.', helperGetRoute());
	return isset($route[2]) ? $route[2] : '';
}