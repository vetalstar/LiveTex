<?php defined('SYSPATH') or die('No direct script access.');

class Model_Relative extends ORM {

	protected $_has_many = array(
		'users'   =>  array(
			'model'         =>  'User',
			'foreign_key'   =>  'relative_id'
		),
	);

	public function filters()
	{
		return array(
			'name'		=>	array(
				array('trim')
			),
		);
	}

	public function rules()
	{
		return array(
			'name'  =>  array(
				array('not_empty'),
				array('max_length', array(':value', 255))
			),
		);
	}

	public function labels()
	{
		return array(
			'name'  =>	'Тип родства',
		);
	}
}