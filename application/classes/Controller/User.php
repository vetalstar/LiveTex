<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template_Main {

	public function before()
	{
		parent::before();

		if ( ! Auth::instance()->logged_in())
			$this->redirect(Route::url('default'));
	}

	public function action_family()
	{
		$user = ORM::factory('User', $this->request->param('user_id'));

		if ( ! $user->loaded())
			throw new HTTP_Exception_404('File not found!');

		$this->template->menu_family = TRUE;
		$this->template->scripts = array(
			'media/js/vendor/raphael.js',
			'media/js/Treant.min.js',
			'media/js/ft.js',
		);


		$cache_id = (Auth::instance()->get_user()->id == $user->id) ? 'user-family_' . $user->id : 'family_' . $user->id;

		$family_json = Cache::instance('memcache')->get($cache_id);

		if (is_null($family_json))
		{
			// Родственники пользователя
			$relatives = $user
				->relatives
				->find_all();

			$tree = new Tree($relativgies);

			$family_json = json_encode($this->treant($tree));

			Cache::instance('memcache')->set($cache_id, $family_json, 60 * 60 * 24 * 7);
		}

		$data = array(
			'user'			=>	$user,
			'family_json'	=>	$family_json,
		);

		$this->template->content = View::factory('user/family', $data);
	}

	public function treant($tree, $parent_id = 0, $level = 0, $arr = array())
	{
		if ( ! isset($tree->_tree[(int) $parent_id]))
			return array(
				'children'	=>	array()
			);

		$i = 0;

		foreach($tree->_tree[$parent_id] as $item)
		{
			$arr['children'][$i] = array(
				'text'	=>	array(
					'name'		=>	$item->name . ' ' . $item->surname,
					'title'		=>	$item->relative->name,
				),
			);

			if (Auth::instance()->get_user()->id == Request::initial()->param('user_id'))
			{
				$arr['children'][$i]['text']['desc'] = array(
					'val'	=>	'Добавить родственника',
					'href'	=>	Route::url('default', array(
						'controller'	=>	'user',
						'action'		=>	'relative',
					)) . URL::query(array('parent_id' => $item->id)),
				);

				$arr['children'][$i]['text']['contact'] = array(
					'val'	=>	'Редактировать',
					'href'	=>	Route::url('default', array(
						'controller'	=>	'user',
						'action'		=>	'relative',
						'id'			=>	$item->id
					))
				);
			}

			if (isset($tree->_tree[$item->id]))
				$arr['children'][$i] = $this->treant($tree, $item->id, $level + 1, $arr['children'][$i]);

			$i++;
		}
//var_dump($arr);
		return $arr;
	}

	public function action_all()
	{
		$this->template->menu_all = TRUE;

		$pagination = Pagination::factory(array(
			'current_page'      =>  array(
				'source'    =>  'query_string',
				'key'       =>  'page'
			),
			'items_per_page'    =>  10,
			'view'              =>  'pagination/basic',
			'auto_hide'         =>  TRUE,
			'first_page_in_url' =>  FALSE,
		))
		->route_params(array(
			'controller'    =>  strtolower($this->request->controller()),
			'action'        =>  $this->request->action(),
		));

		$users = ORM::factory('User');

		$pagination->total_items = $users
			->reset(FALSE)
			->count_all();

		// Выдаю 404 ошибку, если страницы заданным номером не существует

		$param_page = $this->request->initial()->query('page');

		if ( ! is_null($param_page))
		{
			$param_page = (int) $param_page;

			if ($param_page > $pagination->total_pages and ! is_null($this->request->initial()->referrer()))
				$this->redirect($this->request->uri() . URL::query(array(
						'page'  =>  $pagination->total_pages
					)));

			if ($param_page == 0 or $param_page > $pagination->total_pages)
				throw new HTTP_Exception_404('File not found!');
		}

		$users = $users
			->order_by('id', 'DESC')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();

		$this->template->content = View::factory('user/all', array(
			'users'			=>	$users,
			'pagination'	=>	$pagination,
		));
	}

	public function action_relative()
	{
		$this->template->menu_family = TRUE;

		$relative_id = $this->request->param('id');

		if ( ! is_null($relative_id))
		{
			$arr = array(
				'id'		=>	$relative_id,
				'user_id'	=>	Auth::instance()->get_user()->id,
			);

			$relative = ORM::factory('User_Relative', $arr);

			if ( ! $relative->loaded())
				throw new HTTP_Exception_404('File not found!');
		}
		else
		{
			$relative = ORM::factory('User_Relative');
		}

		$fields = array(
			'relative_id',
			'name',
			'surname',
		);
		$post = Arr::extract($this->request->post(), $fields);
		$get = Arr::extract($this->request->query(), array(
			'parent_id',
		));

		if ( ! is_null($get['parent_id']))
		{
			// Проверяю есть ли родственник с таким id у пользователя
			$r = ORM::factory('User_Relative', array(
				'id'		=>	(int) $get['parent_id'],
				'user_id'	=>	Auth::instance()->get_user()->id
			));

			if ( ! $r->loaded())
				throw new HTTP_Exception_404('File not found!');
		}

		$errors = NULL;

		if ($this->request->method() == 'POST')
		{
			try
			{
				$post['user_id'] = Auth::instance()->get_user()->id;

				if ( ! is_null($get['parent_id']))
					$post['parent_id'] = $get['parent_id'];

				$relative
					->values($post)
					->save();

				// Очищаю кэш
				Cache::instance('memcache')->delete('user-family_' . $post['user_id']);
				Cache::instance('memcache')->delete('family_' . $post['user_id']);

				$this->redirect(Route::url('user/id', array('user_id' => $post['user_id'])));
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('orm');
			}
		}
		else
		{
			$post = Arr::extract($relative->as_array(), $fields);
		}

		$types = ORM::factory('Relative')
			->find_all();

		$data = $post + array(
			'relative'	=>	$relative,
			'errors'	=>	$errors,
			'types'		=>	$types,
		);

		$this->template->content = View::factory('user/relative', $data);
	}
}