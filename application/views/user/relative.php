<div class="inner cover">
    <h1 class="cover-heading"><?= ($relative->loaded()) ? 'Редактировать' : 'Добавить' ?></h1>
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
                <label for="relative_id">*Тип родства</label>
                <select name="relative_id" class="form-control">
                    <? foreach($types as $type): ?>
                        <option value="<?= $type->id ?>"<? if ($type->id == $relative_id) { ?> selected<? } ?>><?= $type->name ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">*Имя</label>
                <input type="text" name="name" class="form-control" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">*Фамилия</label>
                <input type="text" name="surname" class="form-control" value="<?= $surname ?>" required>
            </div>
        </div>
        <div class="lead">
            <input type="submit" class="btn btn-lg btn-default" value="Сохранить">
        </div>
    </form>
</div>