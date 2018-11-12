<div class="container-fluid">
    <h1>Регистрация</h1>
    <div class="col-md-3">
        <form action="/register" method="post">
            <input type="hidden" name="request_url"
                   value="<?php if(isset($_GET['request_url']))
                       echo $_GET['request_url'] ?>">
            <div class="row">
                <div class="control-group form-group col-md-6">
                    <label>Имя:</label>
                    <input type="text" class="form-control" name="fname" required="true">
                </div>
                <div class="control-group form-group col-md-6">
                    <label>Фамилия:</label>
                    <input type="text" class="form-control" name="lname" required="true">
                </div>
            </div>

            <div class="control-group form-group">
                <label>E-mail:</label>
                <input type="email" class="form-control" name="email" required="true">
            </div>
            <div class="control-group form-group">
                <label>Пароль:</label>
                <input type="password" class="form-control" name="password" required="true">
            </div>
            <div class="control-group form-group">
                <label>Город:</label>
                <input type="text" class="form-control" name="city">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required>
                    <span> Я ознакомлен и согласен <br> с <a
                                href="/public/docs/protect_policy_of_personal_information.pdf"
                                target="_blank">Политикой конфеденциальности</a>
                    </span>
                </label>
            </div>
            <button type="submit" class="btn btn-default">Регистрация</button>
        </form>
    </div>
</div>