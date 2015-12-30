<?php defined('SYSPATH') OR die('No direct script access.');

class Valid extends Kohana_Valid {

	public static function ru_alpha($str)
	{
		$str = (string) $str;

		return (bool) preg_match("/^[А-Яа-яЁё]+$/u", $str);
	}
	
	public static function surname($str)
	{
		$str = (string) $str;
		
		return (bool) preg_match("/^([А-Яа-яЁё]+|[А-Яа-яЁё]+-[А-Яа-яЁё]+)$/u", $str);
	}
}