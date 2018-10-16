<?php if(!empty($courses)): ?>
<div class="courses row">
    <?php foreach($courses as $course):?>
    <div class="course col-md-4">
        <h2>
            <?=$course['name']?>
        </h2>
        <div class="date-start">
            Дата: <?=date('d.m.Y',$course['timestart'])?>
        </div>
        <div class="date-start">
            Цена:
            <?=$course['price']?>
        </div>
        <div class="param">
            Активный: <?php if($course['active'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
            Приватный: <?php if($course['private'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
            Оплата: <?php if($course['payment'] == 1){echo 'Да';}else{echo 'Нет';}?> <br>
            Цена: <?=$course['price']?>
        </div><br>
        <div class="description">
            <?=$course['caption']?>
        </div><br>
        <!-- <a href="/project/<?=$course['id']?>" class="btn btn-default btn-sm">Подробнее</a> -->
        <a href="/admin/editcourse/<?=$course['id']?>" class="btn btn-default btn-sm">Редактировать</a>
    </div>
    <?php endforeach ?>
</div>
<?php else: ?>
На данный момент нет курсов
<?php endif?>