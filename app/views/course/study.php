<div class="container-fluid">
    <h1>
        <?=$course['name']?>
    </h1>
    <?php if($course['type'] == 1): ?>
        Ждем вас <?=date('d.m.Y', $course['timestart'])?> в <?=date('H:i', $course['timestart'])?> (МСК)
    <?php else: ?>
    <?php if($course['id'] == 3): ?>
       <p>По всем вопросам вы можете обратиться к <a href="https://vk.com/id114084145" target='_blank'>Карине Кушнаренко Вконтакте</a></p>
    <?php endif ?>
    <div class="progress">
        <div class="progress-bar" style="width: <?=$course['percent']?>%">
            <span class="sr-only">Прогресс: <span class="percent">
                    <?=$course['percent']?></span> %</span>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-3"> -->
            Список заданий:
            <ul class="tasks course">
                <?php foreach($tasks as $task): ?>
                <?php if($task['timestart'] <= time()):?>
                <li class="task <? if($task['active'] == 1)echo 'active';?>" data-status="<?=$task['status']?>" data-id="<?=$task['id']?>">
                    <?=$task['title']?>
                    <p><?=$task['description']?></p>
                </li>
                <?php endif ?>
                <?php endforeach ?>
            </ul>
        <!-- </div>
    </div> -->
    <?php endif?>
</div>