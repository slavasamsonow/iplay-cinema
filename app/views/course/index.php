<div class="courses">
    <!--    todo переименовать-->
    <?php if(count($courses) > 0): ?>
        <h1><span class="big">Обучение</span></h1>

        <h2>Активные</h2>
        <?php if(!empty($courses['active'])): ?>
            <div class="row">
                <?php foreach($courses['active'] as $course): ?>
                    <div class="col-lg-4 col-sm-6 course">
                        <h3>
                            <?=$course['name']?>
                        </h3>
                        <div class="small-desk">
                            <?=$course['description']?>
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
        <?php else: ?>
            <p>Сейчас у вас нет активных курсов</p>
        <?php endif ?>

        <?php if(!empty($courses['coming'])): ?>
            <h2>Предстоящие</h2>
            <div class="row">
                <?php foreach($courses['coming'] as $course): ?>
                    <div class="col-lg-4 col-sm-6 course">
                        <h3>
                            <?=$course['name']?>
                        </h3>
                        <div class="small-desk">
                            <?=$course['description']?>
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
        <?php endif ?>

        <?php if(!empty($courses['past'])): ?>
            <h2>Прошедшие</h2>
            <div class="row">
                <?php foreach($courses['past'] as $course): ?>
                    <div class="col-lg-4 col-sm-6 course">
                        <h3>
                            <?=$course['name']?>
                        </h3>
                        <div class="small-desk">
                            <?=$course['description']?>
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
        <?php endif ?>
    <?php else: ?>
        Сейчас у вас нет активных курсов
    <?php endif ?>
</div>