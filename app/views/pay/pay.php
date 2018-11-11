<div class="container-fluid">
    <h1>Оплата</h1>

    <h2>
        Билет на
        <?=$course['name']?>
    </h2>
    <p>
        <?php if($course['type'] == 'event'): ?>
            Дата и время:
            <?=date('d.m.Y H:i', $course['timestart'])?>
        <?php else: ?>
            Дата старта:
            <?=date('d.m.Y', $course['timestart'])?>
        <?php endif ?>
    </p>
    <p>
        <?=$course['caption']?>
    </p>

    <div class="row">
        <form action="/pay/<?=$course['id']?>" method="post" class="col-md-6">
            <input type="hidden" name="action" value="pay">
            <input type="hidden" name="course" value="<?=$course['id']?>">

            <?php if(!isset($_SESSION['user']['id'])): ?>
                <div class="control-group form-group">
                    <label>ФИО:</label>
                    <input type="text" class="form-control" name="fio" required="true"
                           value="<?php if(isset($_SESSION['guest']['fio'])){
                               echo $_SESSION['guest']['fio'];
                           } ?>">
                </div>
                <div class="control-group form-group">
                    <label>E-mail:</label>
                    <input type="email" class="form-control" name="email" required="true"
                           value="<?php if(isset($_SESSION['guest']['email'])){
                               echo $_SESSION['guest']['email'];
                           } ?>">
                </div>
                <div class="control-group form-group">
                    <label>Телефон:</label>
                    <input type="phone" class="form-control" name="phone" required="true"
                           value="<?php if(isset($_SESSION['guest']['phone'])){
                               echo $_SESSION['guest']['phone'];
                           } ?>">
                </div>
                <div class="control-group form-group">
                    <label>Город:</label>
                    <input type="text" class="form-control" name="city"
                           value="<?php if(isset($_SESSION['guest']['city'])){
                               echo $_SESSION['guest']['city'];
                           } ?>">
                </div>
            <?php endif ?>

            <div class="control-group form-group">
                <label>Промо-код:</label>
                <div class="input-group">
                    <?php $promocode = (isset($_GET['promocode'])) ? $_GET['promocode'] : '' ?>
                    <input type="text" class="form-control" name="promocode" value="<?=$promocode?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" data-type="payPromocode">Применить</button>
                    </span>
                </div>
            </div>

            <div class="control-group form-group">
                <label>Сумма:</label>
                <input type="text" class="form-control" name="price" value="<?=$course['newPrice']?>"
                       data-price="<?=$course['price']?>" readonly>
            </div>
            <input type="submit" class="btn" value='Оплатить'>
        </form>
    </div>

</div>