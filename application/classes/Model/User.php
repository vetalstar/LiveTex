<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	protected $_has_many = array(
		'relatives'		=>	array(
			'model'			=>	'User_Relative',
			'foreign_key'	=> 	'user_id'
		),
		'user_tokens'	=>	array(
			'model'	=>	'User_Token'
		),
		'roles'			=>	array(
			'model'		=>	'Role',
			'through'	=>	'roles_users'
		),
	);

	// Фильтры перед сохранением в БД
	public function filters()
	{
		return array(
			'email'		=>	array(
				array(array('UTF8', 'trim')),
				array(array('UTF8', 'strtolower'))
			),
			'password'	=>	array(
				array(array(Auth::instance(), 'hash'))
			),
			'name'		=>	array(
				array(array('UTF8', 'trim')),
				array(array('UTF8', 'strtolower')),
				array(array('UTF8', 'ucfirst'))
			),
			'surname'	=>	array(
				array(array('UTF8', 'trim')),
				array(array('UTF8', 'strtolower')),
				array(array('UTF8', 'ucfirst'))
			),
		);
	}

	// Правила валидации при сохранении
	public function rules()
	{
		return array(
			'password'	=>	array(
				array('not_empty'),
				array('max_length', array(':value', 64))
			),
			'email'		=>	array(
				array('not_empty'),
				array('max_length', array(':value', 254)),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
			'name'		=>	array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('ru_alpha'),
			),
			'surname'	=>	array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('surname'),
			),
		);
	}

	// Названия полей таблицы
	public function labels()
	{
		return array(
			'email'		=>	'Адрес электронной почты',
			'password'	=>	'Пароль',
			'name'		=>	'Имя',
			'surname'	=>	'Фамилия',
		);
	}
}