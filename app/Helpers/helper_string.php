<?php

function helperClearString($str)
{
	$str = str_replace(" ", "_", $str);
	$str = str_replace("'", "", $str);
	return $str;
}

function helperPrefixString($string, $digit)
{
	if (is_string($digit)) return $string;
	if ($digit <= 0) return $string;

	return sprintf('%0'.$digit.'d', $string);
}

function helperGenContentFilename($product_id, $page_id)
{
	return sprintf("%06d", $product_id).sprintf("%08d", $page_id);
}

function helperGenPdfFilename($product_id)
{
	return date('ymdHis').'-'.sprintf("%010d", $product_id);
}