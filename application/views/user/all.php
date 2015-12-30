<div class="inner cover">
	<h1 class="cover-heading">Пользователи</h1>
	<div class="lead text-left">
		<? if ($pagination->total_items > 0): ?>
			<?= $pagination ?>
			<? foreach($users as $user): ?>
				<div>
					<a href="<?= Route::url('user/id', array('user_id' => $user->id)) ?>"><?= $user->name . ' ' . $user->surname ?></a>
				</div>
			<? endforeach; ?>
			<?= $pagination ?>
		<? else: ?>
			<p align="center">
				Пользователей пока нет.
			</p>
		<? endif; ?>
	</div>
</div>