<?php defined('SYSPATH') OR die('No direct script access.');

class Tree {

	public $_tree = array();

	public function __construct($nodes = NULL)
	{
		$this->_initialize($nodes);
	}

	/*
	 * Создаёт массив дерева
	 *
	 * @param	object	$nodes	объект элементов дерева
	 *
	 * @return	void
	 */
	protected function _initialize($nodes)
	{
		foreach($nodes as $node)
		{
			//var_dump($node);
			// В БД parent_id по-умолчанию NULL, чтобы работали связи innoDB
			$this->_tree[(int) $node->parent_id][(int) $node->id] = $node;
		}
	}

	/*
	 * Метод для построения дерева
	 *
	 * @param	string		$file		путь до отображения (вьюхи)
	 * @param	integer		$parent_id	ID родителькой записи
	 * @param	integer		$level		Уровень вложенности
	 *
	 * @return	string
	 * @uses	View::factory
	 * @uses	View::render
	 */
	public function build($file = NULL, $parent_id = 0, $level = 0)
	{
		if ( ! isset($this->_tree[(int) $parent_id]))
			return FALSE;

		$data = array(
			'tree'		=>	$this,
			'file'		=>	$file,
			'parent_id'	=>	$parent_id,
			'level'		=>	$level,
		);

		return View::factory($file, $data)->render();
	}
}