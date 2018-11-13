<h1>Страница создания задания</h1>
<form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
    <input type="hidden" name="course" value="<?=$course['id']?>">
    <div class="control-group form-group">
        <label>Курс: </label>
        <input type="text" class="form-control" value="<?=$course['name']?>" readonly>
    </div>
    <div class="control-group form-group">
        <label>Автор:</label>
        <select class="form-control" name="author">
            <?php foreach($usersList as $userListItem): ?>
                <option value="<?=$userListItem['id']?>" <?php if($_SESSION['user']['id'] == $userListItem['id'])
                    echo
                    'checked'; ?>>
                    <?=$userListItem['fname'].' '.$userListItem['lname']?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="control-group form-group">
        <button type="submit" class="btn btn-default btn-sm">Добавить преподавателя</button>
    </div>
</form>