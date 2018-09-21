<h1>Сменить пароль</h1>
<div class="col-md-3">
    <form action="/account/editpass" method="post">
    <div class="control-group form-group">
        <label>Старый пароль:</label>
        <input type="password" class="form-control" name="oldpassword" required="true">
    </div>
    <div class="control-group form-group">
        <label>Новый пароль:</label>
        <input type="password" class="form-control" name="password" required="true">
    </div>
    <div class="control-group form-group">
        <label>Повторить пароль:</label>
        <input type="password" class="form-control" name="password_confim" required="true">
    </div>
    <button type="submit" class="btn btn-default">Сменить пароль</button>
</form>
</div>