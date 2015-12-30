# Kohana PHP Framework

[Kohana](http://kohanaframework.org/) is an elegant, open source, and object oriented HMVC framework built using PHP5, by a team of volunteers. It aims to be swift, secure, and small.

Released under a [BSD license](http://kohanaframework.org/license), Kohana can be used legally for any open source, commercial, or personal project.

## Documentation
Kohana's documentation can be found at <http://kohanaframework.org/documentation> which also contains an API browser.

The `userguide` module included in all Kohana releases also allows you to view the documentation locally. Once the `userguide` module is enabled in the bootstrap, it is accessible from your site via `/index.php/guide` (or just `/guide` if you are rewriting your URLs).

## Reporting bugs
If you've stumbled across a bug, please help us out by [reporting the bug](http://dev.kohanaframework.org/projects/kohana3/) you have found. Simply log in or register and submit a new issue, leaving as much information about the bug as possible, e.g.

* Steps to reproduce
* Expected result
* Actual result

This will help us to fix the bug as quickly as possible, and if you'd like to fix it yourself feel free to [fork us on GitHub](https://github.com/kohana) and submit a pull request!

1. Импортировать trash.sql в базу данных
2. Переименовать unistall.php в install.php. Проверить может ли работать фреймворк.
   Если всё ок переименовать обратно.
3. Создать конфиг подключения к БД application\config\database.php
Пример:

<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'MySQLi',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * array    variables    system variables as "key => value" pairs
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => 'localhost',
			'database'   => 'name_bd',
			'username'   => 'user_bd',
			'password'   => 'pass_bd',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	)
);

4. В папке application должны быть папки
application/cache
application/logs

и иметь права на запись