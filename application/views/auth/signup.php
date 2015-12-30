<div class="inner cover">
	<h1 class="cover-heading">Создать мое семейное дерево</h1>
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
				<label for="name">*Ваше имя</label>
				<input type="text" name="name" class="form-control" value="<?= $name ?>" required>
			</div>
			<div class="form-group">
				<label for="surname">*Ваша фамилия</label>
				<input type="text" name="surname" class="form-control" value="<?= $surname ?>" required>
			</div>
			<div class="form-group">
				<label for="email">*Ваш адрес электронной почты</label>
				<input type="email" name="email" class="form-control" value="<?= $email ?>" required>
			</div>
		</div>
		<div class="lead">
			<input type="submit" class="btn btn-lg btn-default" value="Зарегистрироваться">
		</div>
	</form>
</div>