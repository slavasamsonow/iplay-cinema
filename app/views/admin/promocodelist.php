<h1><span class="big">Промокоды</span></h1>
<a href="/admin/addpromocode" class="btn">Создать новый промокод</a>
<?php if(!empty($promocodes)): ?>
    <div class="promocodelist">
        <?php for($i = 0; $i < count($promocodes); $i++): ?>
            <?php if($i % 3 == 0): ?>
                <div class="row">
            <?php endif ?>
            <div class="news col-md-4">
                <h2>
                    <?=$promocodes[$i]['code']?>
                </h2>
                <div class="sale">
                    Скидка:
                    <?=$promocodes[$i]['sale']?>
                </div>
                <div class="course">
                    Курс:
                    <?php if($promocodes[$i]['course'] == 'all'): ?>
                        все
                    <?php else: ?>
                        <?=$promocodes[$i]['courseName']?>
                    <?php endif ?>
                </div>
                <div class="date-start">
                    Дата старта:
                    <?php if($promocodes[$i]['timestart'] == 0): ?>
                        Не указана
                    <?php else: ?>
                        <?=date('d.m.Y H:i', $promocodes[$i]['timestart'])?>
                    <?php endif ?>
                </div>
                <div class="date-end">
                    Дата конца:
                    <?php if($promocodes[$i]['noEnd'] == 1): ?>
                        Без конца
                    <?php else: ?>
                        <?=date('d.m.Y H:i', $promocodes[$i]['timeend'])?>
                    <?php endif ?>
                </div>
                <div class="param">
                    Активный:
                    <?php if($promocodes[$i]['active'] == 1){
                        echo 'Да';
                    }else{
                        echo 'Нет';
                    } ?>
                </div>
                <a href="/admin/editpromocode/<?=$promocodes[$i]['id']?>"
                   class="btn btn-default btn-sm">Редактировать</a>
            </div>
            <?php if($i % 3 == 2 || $i + 1 == count($promocodes)): ?>
                </div>
            <?php endif ?>
        <?php endfor ?>
    </div>
<?php else: ?>
    <div>
        На данный момент нет промокодов
    </div>
<?php endif ?>