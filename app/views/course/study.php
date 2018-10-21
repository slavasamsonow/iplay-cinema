<div class="container-fluid">
    <h1>
        <?=$course['name']?>
    </h1>
    <?php if($course['type'] == 1): ?>
    Ждем вас
    <?=date('d.m.Y', $course['timestart'])?> в
    <?=date('H:i', $course['timestart'])?> (МСК)
    <?php else: ?>

    <?php if($course['id'] == 3): ?>
    <p>По всем вопросам вы можете обратиться к <a href="https://vk.com/id114084145" target='_blank'>Карине Кушнаренко
            Вконтакте</a></p>
    <?php endif ?>
    <div class="progress">
        <div class="progress-bar" style="width: <?=$course['percent']?>%">
            <span class="sr-only">Прогресс: <span class="percent">
                    <?=$course['percent']?></span> %</span>
        </div>
    </div>
    <h2>Задания</h2>
    <div class="tasks course">
        <?php foreach($tasks as $dayName => $dayTasks):?>
        <?php
        $dayClassList = ' ';
        if($dayName == date('d.m.Y', time())) $dayClassList .= ' today';
        ?>
        <div class="day <?=$dayClassList?>">
            <div class="name"><?=$dayName ?></div>
            <div class="tasks-list">
                <?php foreach($dayTasks as $task):?>
                <?php
                $taskClassList = ' ';
                if($task['active'] == 1) $taskClassList .= ' active';
                ?>
                <div class="task <?=$taskClassList?>" data-status="<?=$task['status']?>">
                    <button data-id="<?=$task['id']?>"></button>
                    <div class="task-info">
                        <h4 class="task-name"><?=$task['name']?></h4>
                        <p class="task-description"><?=$task['description']?></p>
                        <p class="task-comment"><?=$task['comment']?></p>
                        <p class="task-error"></p>
                    </div>

                </div>
                <?php endforeach ?>
            </div>

        </div>
        <?php endforeach ?>
    </div>
    <!-- Список заданий: -->
    <!-- <ul class="tasks course">
        <?php foreach($tasks as $task): ?>
        <?php if($task['timestart'] <= time()):?>
        <li class="task <? if($task['active'] == 1)echo 'active';?>" data-status="<?=$task['status']?>" data-id="<?=$task['id']?>">
            <?=$task['title']?>
            <p>
                <?=$task['description']?>
            </p>
        </li>
        <?php endif ?>
        <?php endforeach ?>
    </ul> -->
    <?php endif?>
</div>