<div class="container-fluid">
    <h1>Изменение информации</h1>
    <form action="/admin/edituser/<?=$userInfo['id']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="oldphoto" value="<?=$userInfo['photo']?>">
        <input type="hidden" name="userid" value="<?=$userInfo['id']?>">
        <div class="row">
            <div class="control-group form-group col-md-6">
                <label>Имя:</label>
                <input type="text" class="form-control" name="fname" value="<?=$userInfo['fname']?>" required="true">
            </div>
            <div class="control-group form-group col-md-6">
                <label>Фамилия:</label>
                <input type="text" class="form-control" name="lname" value="<?=$userInfo['lname']?>" required="true">
            </div>
        </div>
        <div class="control-group form-group">
            <label>Обо мне:</label>
            <textarea class="form-control" name="about" id=""><?=$userInfo['about']?></textarea>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="public" value="1" <? if($userInfo['public'] == 1)
                    echo 'checked'; ?>>
                <span> Публичный профиль </span>
            </label>
        </div>
        <div class="control-group form-group">
            <label>Загрузить новое фото:</label>
            <input type="file" name="photo">
        </div>
        <button type="submit" class="btn btn-default">Сохранить данные</button>
    </form>
</div>