<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<title><?= $title ?></title>
	<?
	foreach($styles as $file => $type)
		echo HTML::style($file, array('media' => $type)), "\n";
	?>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
			<div class="masthead clearfix">
				<div class="inner">
					<h3 class="masthead-brand">LiveTex</h3>
					<nav>
						<ul class="nav masthead-nav">
							<? if ( ! Auth::instance()->logged_in()): ?>
							<li<? if (isset($menu_signup)): ?> class="active"<? endif; ?>>
								<a href="<?= Route::url('default') ?>">Регистрация</a>
							</li>
							<li<? if (isset($menu_login)): ?> class="active"<? endif; ?>>
								<a href="<?= Route::url('default', array('controller' => 'auth', 'action' => 'login')) ?>">Войти</a>
							</li>
							<? else: ?>
							<li<? if (isset($menu_family)): ?> class="active"<? endif; ?>>
								<a href="<?= Route::url('user/id', array('user_id' => Auth::instance()->get_user()->id)) ?>">Древо</a>
							</li>
							<? endif; ?>
							<li<? if (isset($menu_all)): ?> class="active"<? endif; ?>>
								<a href="<?= Route::url('default', array('controller' => 'user', 'action' => 'all')) ?>">Люди</a>
							</li>
							<? if (Auth::instance()->logged_in()): ?>
							<li>
								<a href="<?= Route::url('default', array('controller' => 'auth', 'action' => 'logout')) ?>">Выйти</a>
							</li>
							<? endif; ?>
						</ul>
					</nav>
				</div>
			</div>
			<?= $content ?>
		</div>
	</div>
</div>
<?
foreach($scripts as $file)
	echo HTML::script($file), "\n";
?>
</body>
</html>