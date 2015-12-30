<?php defined('SYSPATH') or die('No direct script access.');

class Model_User_Relative extends ORM {

	protected $_table_name = 'user_relatives';

	protected $_belongs_to = array(
		'user'				=>	array(
			'model'			=>	'User',
			'foreign_key'	=>	'user_id'
		),
		'relative'			=>	array(
			'model'			=>	'Relative',
			'foreign_key'	=>	'relative_id'
		),
	);

	public function filters()
	{
		return array(
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

	public function rules()
	{
		return array(
			'parent_id'		=>	array(
				array('digit', array(':value', TRUE)),
				array(array(ORM::factory('User_Relative', $this->parent_id), 'loaded'))
			),
			'user_id'		=>	array(
				array('not_empty'),
				array('digit', array(':value', TRUE)),
				array(array(ORM::factory('User', $this->user_id), 'loaded'))
			),
			'relative_id'	=>	array(
				array('not_empty'),
				array('digit', array(':value', TRUE)),
				array(array(ORM::factory('Relative', $this->relative_id), 'loaded'))
			),
			'name'			=>	array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('ru_alpha'),
			),
			'surname'		=>	array(
				array('not_empty'),
				array('max_length', array(':value', 255)),
				array('surname'),
			),
		);
	}

	public function labels()
	{
		return array(
			'parent_id'		=>	'Родственник',
			'user_id'		=>	'Пользователь',
			'name'			=>	'Имя',
			'surname'		=>	'Фамилия',
		);
	}
}