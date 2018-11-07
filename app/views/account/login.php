<div class="container-fluid">
    <h1>Вход</h1>
    <div class="col-md-3">
        <form action="/login" method="post">
            <?php if(isset($_SERVER['HTTP_REFERER'])): ?>
                <?php if(strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])): ?>
                    <?php
                    $urlInnerPos = strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'].'/');
                    $urlInner = substr($_SERVER['HTTP_REFERER'], $urlInnerPos + iconv_strlen($_SERVER['HTTP_HOST']) + 1);
                    ?>
                    <input type="hidden" name="request_url" value="<?=$urlInner?>">
                <?php endif ?>
            <? endif ?>
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
</div>