<h1>Создать новый проект</h1>
<div class="row">
    <form action="/admin/addproject" method="post" class="col-md-6">
        <div class="control-group form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="true">
        </div>
        <div class="control-group form-group">
            <label>Описание:</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="control-group form-group">
            <label>Автор:</label>
            <select class="form-control" name="creator">
                <?php foreach($userList as $userListItem):?>
                <option value="<?=$userListItem['id']?>">
                    <?=$userListItem['fname'].' '.$userListItem['lname']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="active" checked>
                <span> Активный </span>
            </label>
        </div> -->
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Создать проект</button>
        </div>
    </form>
</div>