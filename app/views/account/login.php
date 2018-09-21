<h1>Вход</h1>
<div class="col-md-3">
    <form action="/login" method="post">
        <div class="control-group form-group">
            <label>Логин:</label>
            <input type="text" class="form-control" name="username" required="true">
        </div>
        <div class="control-group form-group">
            <label>Пароль:</label>
            <input type="password" class="form-control" name="password" required="true">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" value="remember"> Запомнить меня
            </label>
        </div>
        <button type="submit" class="btn btn-default">Вход</button>
    </form>
</div>