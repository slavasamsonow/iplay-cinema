<h1><span class="big">Все курсы</span></h1>
<div class="coursesType">
    <a href="/courses">Все</a>
    <a href="/courses?type=event">Мероприятия</a>
    <a href="/courses?type=basic">Базовый курс</a>
    <a href="/courses?type=main">Основной курс</a>
</div>
<?php if(!empty($coursesList)):?>
<div class="courseslist">
    <?php for($i = 0; $i < count($coursesList); $i++):?>
    <?php $course = $coursesList[$i]?>
    <?php if($i % 3 == 0):?>
    <div class="row">
        <?php endif ?>
        <div class="col-md-4">
            <h2><a href="/course/<?=$course['id']?>">
                    <?=$course['name']?></a></h2>
            <div class="description">
                <?=$course['caption']?>
            </div>
        </div>
        <?php if($i % 3 == 2 || $i + 1 == count($coursesList)):?>
    </div>
    <?php endif ?>
    <?php endfor ?>

</div>
<?php else: ?>
На данный момент нет активных курсов
<?php endif ?>