<h1>Создать новую новость</h1>
<div class="row">
    <form action="/admin/addnews" method="post" class="col-md-6">
        <div class="control-group form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="title" required="true">
        </div>
        <div class="control-group form-group">
            <label>Дата и время</label>
            <input type="text" class="form-control" name="datetime" required="true" value="<?=date('d.m.Y H:i:m', time())?>">
        </div>
        <div class="control-group form-group">
            <label>Краткая аннотация:</label>
            <textarea class="form-control" name="caption"></textarea>
        </div>
        <div class="control-group form-group">
            <label>Содержание:</label>
            <textarea class="form-control" name="content"></textarea>
        </div>
        <div class="control-group form-group">
            <label>Фото:</label>
            <input type="file" name="image">
        </div>
        <div class="control-group form-group">
            <label>Автор:</label>
            <select class="form-control" name="author">
                <?php foreach($usersList as $userListItem):?>
                <option value="<?=$userListItem['id']?>" <?php if($_SESSION['user']['id'] == $userListItem['id']) echo 'checked';?>>
                    <?=$userListItem['fname'].' '.$userListItem['lname']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Создать новость</button>
        </div>
    </form>
</div>