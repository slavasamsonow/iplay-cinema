<div class="courses">
    <?php if(count($courses) > 0): ?>
        <h1><span class="big">Обучение</span></h1>
        <?php foreach($courses as $typeName => $coursesType): ?>
            <h2><?=$typeName?></h2>
            <div class="row">
                <?php foreach($coursesType as $course): ?>
                    <div class="col-lg-4 col-sm-6 course">
                        <h3>
                            <?=$course['name']?>
                        </h3>
                        <div class="small-desk">
                            <?=$course['caption']?>
                        </div>
                        <?php if($course['type'] == 1): ?>
                            <div class="date"><h4><?=date('d.m.Y', $course['timestart'])?>
                                    в <?=date('H:i', $course['timestart'])?> (МСК) </h4></div>
                        <?php else: ?>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?=$course['percent']?>%">
                    <span class="sr-only">Прогресс:
                        <?=$course['percent']?> %</span>
                                </div>
                            </div>
                            <a href="/study/<?=$course['id']?>" class="btn btn-default btn-sm">Открыть</a>
                            <a href="/course/<?=$course['id']?>" class="btn btn-default btn-sm">Подробнее</a>
                        <?php endif ?>
                    </div>
                <? endforeach ?>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        Сейчас у вас нет активных курсов
    <?php endif ?>
</div>