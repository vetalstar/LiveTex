<?php defined('SYSPATH') or die('No direct script access.');

// Основной конкроллер генерирующий шаблон
class Controller_Template_Main extends Controller_Template {
	public $template = 'template/main';

	// Выполняется автоматически до вызова метода контроллера
	public function before()
	{
		parent::before();

		if ($this->auto_render)
		{
			// Инициализация свойств
			$this->template->title = '';

			$this->template->styles = array();
			$this->template->scripts = array();

			$this->template->menu = '';
			$this->template->content = '';
		}
	}

	// Выполняется автоматически после вызова метода контроллера
	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'media/css/bootstrap.min.css'	=>	'screen',
				'media/css/style.css'			=>	'screen',
			);

			$scripts = array(
				'media/js/jquery-1.11.3.min.js',
				'media/js/bootstrap.min.js',
			);

			$this->template->title = 'Генеалогическое древо для LiveTex';

			$this->template->styles = Arr::merge($this->template->styles, $styles);
			$this->template->scripts = Arr::merge($this->template->scripts, $scripts);
		}

		parent::after();
	}
}