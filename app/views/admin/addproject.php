<div class="container-fluid">
    <h1>Создать новый проект</h1>
    <div class="row">
        <form action="/admin/addproject" method="post" class="col-md-6">
            <div class="control-group form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" required="true">
            </div>
            <div class="control-group form-group">
                <label>Краткая аннотация:</label>
                <textarea class="form-control" name="caption"></textarea>
            </div>
            <div class="control-group form-group">
                <label>Описание:</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="control-group form-group">
                <label>Видео (только краткая ссылка c youtube):</label>
                <input type="text" class="form-control" name="video">
            </div>
            <div class="control-group form-group">
                <label>Фото:</label>
                <input type="file" name="image">
            </div>

            <div class="control-group form-group">
                <label>Автор:</label>
                <select class="form-control" name="creator">
                    <?php foreach($usersList as $userListItem): ?>
                        <option value="<?=$userListItem['id']?>">
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
                        <option value="<?=$coursesListItem['id']?>">
                            <?=$coursesListItem['name']?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="control-group form-group">
                <button type="submit" class="btn btn-default btn-sm">Создать проект</button>
            </div>
        </form>
    </div>
</div>