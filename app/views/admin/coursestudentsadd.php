<div class="container-fluid">
    <h1>Страница прикрепления студента</h1>
    <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
        <div class="control-group form-group">
            <label>Курс: </label>
            <input type="text" class="form-control" value="<?=$course['name']?>" readonly>
        </div>
        <div class="control-group form-group">
            <label>Студент:</label>
            <select class="form-control" name="user">
                <?php foreach($usersList as $userListItem): ?>
                    <option value="<?=$userListItem['id']?>">
                        <?=$userListItem['fname'].' '.$userListItem['lname']?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Добавить студента</button>
        </div>
    </form>
</div>