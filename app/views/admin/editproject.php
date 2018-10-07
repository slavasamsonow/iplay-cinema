<h1>Редактирование проекта</h1>
<div class="row">
    <form action="/admin/editproject/<?=$project['id']?>" method="post" class="col-md-6">
        <input type="hidden" name="projectid" value="<?=$project['id']?>">
        <div class="control-group form-group">
            <label>Название: </label>
            <input type="text" class="form-control" name="name" required="true" value="<?=$project['name']?>">
        </div>
        <div class="control-group form-group">
            <label>Описание: </label>
            <textarea class="form-control" name="description"><?=$project['description']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Автор:</label>
            <select class="form-control" name="creator">
                <?php foreach($userList as $userListItem):?>
                <option value="<?=$userListItem['id']?>" <?php if($project['creator'] == $userListItem['id'])echo 'checked' ?>>
                    <?=$userListItem['fname'].' '.$userListItem['lname']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="1" <?php if($project['active'] == 1)echo 'checked' ?>>
                <span> Активный </span>
            </label>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Редактировать проект</button>
        </div>
    </form>
</div>