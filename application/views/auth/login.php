<div class="inner cover">
	<h1 class="cover-heading">Вход</h1>
	<? if ( ! is_null($errors) and is_array($errors)): ?>
		<p class="text-left text-danger">
			<? foreach($errors as $error): ?>
				<?= nl2br($error . "\n") ?>
			<? endforeach; ?>
		</p>
	<? endif; ?>
	<form method="POST">
		<div class="lead">
			<div class="form-group">
				<label for="email">*Ваш адрес электронной почты</label>
				<input type="email" name="email" class="form-control" value="<?= $email ?>" required>
			</div>
			<div class="form-group">
				<label for="password">*Пароль</label>
				<input type="password" name="password" class="form-control" value="<?= $password ?>" required>
			</div>
		</div>
		<div class="lead">
			<input type="submit" class="btn btn-lg btn-default" value="Войти">
		</div>
	</form>
</div>