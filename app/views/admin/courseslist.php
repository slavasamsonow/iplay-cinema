<h1><span class="big">Курсы</span></h1>
<a href="/admin/addcourse" class="btn">Создать новый курс</a>
<?php if(!empty($courses)): ?>
<div class="courses">
    <?php for($i = 0; $i < count($courses); $i++): ?>
    <?php if($i % 3 == 0):?>
    <div class="row">
        <?php endif ?>
        <div class="course col-md-4">
            <h2>
                <?=$courses[$i]['name']?>
            </h2>
            <div class="date-start">
                Дата:
                <?=date('d.m.Y',$courses[$i]['timestart'])?>
            </div>
            <div class="param">
                Активный:
                <?php if($courses[$i]['active'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
                Приватный:
                <?php if($courses[$i]['private'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
                Оплата:
                <?php if($courses[$i]['payment'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
                Цена:
                <?=$courses[$i]['price']?>
            </div><br>
            <div class="description">
                <?=$courses[$i]['caption']?>
            </div><br>
            <!-- <a href="/project/<?=$courses[$i]['id']?>" class="btn btn-default btn-sm">Подробнее</a> -->
            <a href="/admin/editcourse/<?=$courses[$i]['id']?>" class="btn btn-default btn-sm">Редактировать</a>
            <a href="/admin/taskslist/<?=$courses[$i]['id']?>" class="btn btn-sm">Задания</a>
        </div>
        <?php if($i % 3 == 2):?>
    </div>
    <?php endif ?>
    <?php endfor?>
</div>
<?php else: ?>
На данный момент нет курсов
<?php endif?>