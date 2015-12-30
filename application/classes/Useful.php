<?php defined('SYSPATH') OR die('No direct script access.');

class Useful {
	
	public static function mail($to = '', $title = '', $message = '', $from = '')
	{
		$title = '=?UTF-8?B?' . base64_encode($title) . '?=';

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= 'From: =?UTF-8?B?' . base64_encode($from) . '?= <noreply@' . $_SERVER['HTTP_HOST'] . '>';

		mail($to, $title, $message, $headers);
	}
}