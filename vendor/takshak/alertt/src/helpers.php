<?php


function alertt($message=null)
{
	$alertt = app('alertt');
	return $message ? app('alertt')->message($message) : $alertt;
}