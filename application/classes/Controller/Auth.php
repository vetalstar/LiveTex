<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Template_Main {

	public function action_signup()
	{
		$this->template->menu_signup = TRUE;

		// Если залогинен, то перекидываем на дерево
		if (Auth::instance()->logged_in())
			$this->redirect(Route::url('user/id', array(
				'user_id'	=>	Auth::instance()->get_user()->id
			)));

		$post = Arr::extract($this->request->post(), array(
			'name',
			'surname',
			'email',
		));

		$data['errors'] = NULL;

		if ($this->request->method() == 'POST')
		{
			// Генерирую случайный пароль из цифр
			$post['password'] = Text::random('numeric', 5);

			try
			{
				$user = ORM::factory('User')
					->values($post)
					->save();

				$user
					->add('roles', ORM::factory('Role', array('name' => 'login')));

				$message = '
						Для входа на сайт ' . $_SERVER['HTTP_HOST'] . ' используйте следующие данные:<br><br>
						Адрес электронной почты: ' . HTML::chars($user->email) . '<br>
						Пароль: ' . HTML::chars($post['password']) . '<br><br>
						<a href="' . URL::base(TRUE) . '">Перейти на сайт</a>';

				Useful::mail($user->email, 'Регистрация LiveTex', $message, 'LiveTex');

				// Авторизовываю
				Auth::instance()->login($user->email, $post['password'], TRUE);

				$this->redirect(Route::url('user/id', array(
					'user_id'	=>	$user->id
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$data['errors'] = $e->errors('orm');
			}
		}

		$data += $post;

		$this->template->content = View::factory('auth/signup', $data);
	}

	public function action_login()
	{
		$this->template->menu_login = TRUE;

		// Если залогинен, то перекидываем на дерево
		if (Auth::instance()->logged_in())
			$this->redirect(Route::url('user/id', array(
				'user_id'	=>	Auth::instance()->get_user()->id
			)));

		$post = Arr::extract($this->request->post(), array(
			'email',
			'password',
		));

		$data['errors'] = NULL;

		if ($this->request->method() == 'POST')
		{
			$valid = Validation::factory($post)
				->rules('email', array(
					array('not_empty')
				))
				->rules('password', array(
					array('not_empty')
				))
				->labels(array(
					'email'		=>	'Адрес электронной почты',
					'password'	=>	'Пароль'
				));

			if ( ! $valid->check())
			{
				$data['errors'] = $valid->errors('valid');
			}
			else
			{
				if (Auth::instance()->login($valid['email'], $valid['password'], TRUE))
				{
					// Авторизация прошла успешно
					if ( ! is_null($this->request->referrer()))
						$this->redirect($this->request->referrer());
					else
						$this->redirect(Route::url('user/id', array('user_id' => Auth::instance()->get_user()->id)));
				}
				else
				{
					$data['errors'] = array(
						'usermail'	=>	'',
						'userpass' 	=>	Kohana::message('valid', 'login.incorrect')
					);
				}
			}
		}

		$data += $post;

		$this->template->content = View::factory('auth/login', $data);
	}

	public function action_logout()
	{
		Auth::instance()->logout();

		if ( ! is_null($this->request->referrer()))
			$this->redirect($this->request->referrer());
		else
			$this->redirect(Route::url('default'));
	}
}