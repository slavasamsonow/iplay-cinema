<div class="container-fluid">
    <h1>Оплата</h1>

    <h2>
        <?php
        if($course['type'] == 'Вводный курс'){
            echo $course['name'];
        }
        else{
            echo $course['type'] .': '. $course['name'];
        }
        ?>
    </h2>
    <p>
        <?php echo ($course['type'] == 'Мероприятие') ? 'Дата: ' : 'Дата старта: ';?>
        <?=date('d.m.Y',$course['timestart'])?> <br>
        Сумма:
        <?=$course['price']?>
    </p>
    <p>
        <?=$course['description']?>
    </p>

    <?php if(isset($_SESSION['user']['id'])): ?>
    <form action="/pay/<?=$course['id']?>" method="post">
        <input type="hidden" name='paymentid' value="<?=$pay['paymentid']?>">
        <input type="hidden" name='amoid' value="<?=$pay['amoid']?>">
        <input type="hidden" name='yandexConfirmation' value="<?=$pay['yandexConfirmation']?>">
        <input type="submit" class="btn btn-default" value='Оплатить'>
    </form>
    <?php else: ?>
    <form action="/pay/<?=$course['id']?>" method="post">
        <div class="control-group form-group">
            <label>E-mail:</label>
            <input type="email" class="form-control" name="email" required="true">
        </div>
        <input type="submit" class="btn btn-default" value='Оплатить'>
    </form>
    <!--
    Для оплаты требуется войти в личный кабинет, если вы уже зарегистрированы, либо зарегистрироваться <br><br>
    <a href="/login?request_url=pay/<?=$course['id']?>" class="btn" style="margin-right: 20px;">Войти</a>
    <a href="/register?request_url=pay/<?=$course['id']?>" class="btn">Зарегистрироваться</a>
    -->
    <?php endif ?>
</div>