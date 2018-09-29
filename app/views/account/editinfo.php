<div class="container-fluid">
    <h1>Изменение информации</h1>
    <div class="col-md-3">
        <form action="/account/editinfo" method="post">
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
                    <input type="text" class="form-control" name="username" value="<?=$user['username']?>">
                </div>
            <div class="control-group form-group">
                <label>Обо мне:</label>
                <textarea class="form-control" name="about" id=""><?=$user['about']?></textarea>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="public" value="public" <? if($user['public'] == 1) echo 'checked';?>>
                    <span> Публичный профиль </span>
                </label>
            </div>
            <button type="submit" class="btn btn-default">Сменить пароль</button>
        </form>
    </div>
</div>