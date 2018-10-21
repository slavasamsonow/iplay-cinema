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
    <p>Домашние задания отправляйте <a href="https://vk.com/id114084145" target='_blank'>Карине Кушнаренко
            Вконтакте</a>, а после ставьте галочки</p>
    <?php endif ?>
    <div class="progress">
        <div class="progress-bar" style="width: <?=$course['percent']?>%">
            <span class="sr-only">Прогресс:
                <span class="percent">
                    <?=$course['percent']?>
                </span> %
            </span>
        </div>
    </div>
    <h2>Задания</h2>
    <div class="tasks course">
        <?php foreach($tasks as $dayName => $dayTasks):?>
        <?php
        $dayClassList = '';
        $dayCaption = '';
        if($dayName == date('d.m.Y', time())){
            $dayClassList .= 'today open';
            $dayCaption = '(сегодня)';
        }

        ?>
        <div class="day <?=$dayClassList?>">
            <div class="name">
                <?=$dayName ?>
                <?=$dayCaption?>
            </div>
            <div class="tasks-list">
                <?php foreach($dayTasks as $task):?>
                <?php
                $taskClassList = '';
                if($task['active'] == 1) $taskClassList .= 'active';
                ?>
                <div class="task <?=$taskClassList?>" data-status="<?=$task['status']?>">
                    <button data-id="<?=$task['taskid']?>"></button>
                    <div class="task-info">
                        <h4 class="task-name">
                            <?=$task['name']?>
                        </h4>
                        <p class="task-description">
                            <?=$task['description']?>
                        </p>
                        <p class="task-comment">
                            <?=$task['comment']?>
                        </p>
                        <p class="task-error"></p>
                    </div>

                </div>
                <?php endforeach ?>
            </div>

        </div>
        <?php endforeach ?>
    </div>
    <?php endif?>
</div>