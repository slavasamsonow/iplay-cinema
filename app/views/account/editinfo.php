<h1>Изменение информации</h1>
<form action="/account/editinfo" method="post" enctype="multipart/form-data">
    <input type="hidden" name="oldphoto" value="<?=$user['photo']?>">
    <div class="row">
        <div class="control-group form-group col-md-6">
            <label>Имя:</label>
            <input type="text" class="form-control" name="fname" value="<?=$user['fname']?>" required="true">
        </div>
        <div class="control-group form-group col-md-6">
            <label>Фамилия:</label>
            <input type="text" class="form-control" name="lname" value="<?=$user['lname']?>" required="true">
        </div>
    </div>
    <div class="control-group form-group">
        <label>Имя пользователя:</label>
        <?php
        if(preg_match('#^id[0-9]+$#', $user['username'])){
            $oldusername = '';
        }
        else{
            $oldusername = $user['username'];;
        }
        ?>
        <input type="text" class="form-control" name="username" value="<?=$oldusername?>">
    </div>
    <div class="control-group form-group">
        <label>Обо мне:</label>
        <textarea class="form-control" name="about" id=""><?=$user['about']?></textarea>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="public" value="public" <? if($user['public'] == 1)
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