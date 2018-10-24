<h1>Создать новую новость</h1>
<div class="row">
    <form action="/admin/editnews/<?=$news['id']?>" method="post" class="col-md-6">
        <input type="hidden" name="newsid" value="<?=$news['id']?>">
        <div class="control-group form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="title" required="true" value="<?=$news['title']?>">
        </div>
        <div class="control-group form-group">
            <label>Дата и время</label>
            <input type="text" class="form-control" name="datetime" required="true" value="<?=date('d.m.Y H:i:m', $news['timestart'])?>">
        </div>
        <div class="control-group form-group">
            <label>Краткая аннотация:</label>
            <textarea class="form-control" name="caption"><?=$news['caption']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Содержание:</label>
            <textarea class="form-control" name="content"><?=$news['content']?></textarea>
        </div>
        <div class="control-group form-group">
            <label>Фото:</label>
            <input type="file" name="image">
        </div>
        <div class="control-group form-group">
            <label>Автор:</label>
            <select class="form-control" name="author">
                <?php foreach($usersList as $userListItem):?>
                <option value="<?=$userListItem['id']?>" <?php if($news['author'] == $userListItem['id']) echo 'checked';?>>
                    <?=$userListItem['fname'].' '.$userListItem['lname']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="active" value="1" <?php if($news['active'] == 1) echo 'checked';?>>
                <span> Активный </span>
            </label>
        </div>
        <div class="control-group form-group">
            <button type="submit" class="btn btn-default btn-sm">Редактировать новость</button>
        </div>
    </form>
</div>