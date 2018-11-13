<div class="container-fluid">
    <h1>Редактирование проекта</h1>
    <div class="row">
        <form action="/admin/editproject/<?=$project['id']?>" method="post" class="col-md-6">
            <input type="hidden" name="projectid" value="<?=$project['id']?>">
            <input type="hidden" name="oldimage" value="<?=$project['image']?>">
            <div class="control-group form-group">
                <label>Название: </label>
                <input type="text" class="form-control" name="name" required="true" value="<?=$project['name']?>">
            </div>
            <div class="control-group form-group">
                <label>Краткая аннотация:</label>
                <textarea class="form-control" name="caption"><?=$project['caption']?></textarea>
            </div>
            <div class="control-group form-group">
                <label>Описание: </label>
                <textarea class="form-control" name="description"><?=$project['description']?></textarea>
            </div>
            <div class="control-group form-group">
                <label>Видео (только краткая ссылка c youtube):</label>
                <input type="text" class="form-control" name="video" value="<?=$project['video']?>">
            </div>
            <div class="control-group form-group">
                <label>Фото:</label>
                <input type="file" name="image">
            </div>
            <div class="control-group form-group">
                <label>Автор:</label>
                <select class="form-control" name="creator">
                    <?php foreach($userList as $userListItem): ?>
                        <option value="<?=$userListItem['id']?>" <?php if($project['creator'] == $userListItem['id'])
                            echo 'selected' ?>>
                            <?=$userListItem['fname'].' '.$userListItem['lname']?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="control-group form-group">
                <label>Курс:</label>
                <select class="form-control" name="course">
                    <option value="0">Без привязки</option>
                    <?php foreach($coursesList as $coursesListItem): ?>
                        <option value="<?=$coursesListItem['id']?>" <?php if($project['course'] == $coursesListItem['id'])
                            echo 'selected' ?>>
                            <?=$coursesListItem['name']?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" value="1" <?php if($project['active'] == 1)
                        echo 'checked' ?>>
                    <span> Активный </span>
                </label>
            </div>
            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Редактировать проект</button>
            </div>
        </form>
    </div>
</div>