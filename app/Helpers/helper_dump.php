<?php

function sd($d)
{
    echo '<pre>';
    print_r($d);
    echo '</pre>';
    die();
}

function d($d)
{
    echo '<pre>';
    print_r($d);
    echo '</pre>';
}

function helperReturnErrorFormRequest($field, $message = '')
{
	header('HTTP/1.1 422 Unprocessable Entity');
	$responseText[$field][0] = $message;
	die(json_encode($responseText));
}

function helperReturnErrorFormRequestArray($fields)
{
    header('HTTP/1.1 422 Unprocessable Entity');

    foreach ($fields as $field => $message) {

        $responseText[$field][] = $message;
    }

    die(json_encode($responseText));
}

function helperReturnErrorTokenExpiredArray($fields)
{
    header('HTTP/1.1 423 Unprocessable Entity');

    foreach ($fields as $field => $message) {

        $responseText[$field][] = $message;
    }

    die(json_encode($responseText));
}