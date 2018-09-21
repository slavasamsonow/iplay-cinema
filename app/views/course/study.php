<h1><?=$course['name']?></h1>
<div class="progress">
    <div class="progress-bar" style="width: <?=$course['percent']?>%">
        <span class="sr-only">Прогресс: <span class="percent"><?=$course['percent']?></span> %</span>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        Список заданий:
        <ul class="tasks course">
            <?php foreach($tasks as $task): ?>
                <?php if($task['timestart'] <= time()):?>
                    <li class="task <? if($task['active'] == 1)echo 'active';?>" data-status="<?=$task['status']?>" data-id="<?=$task['id']?>">
                        <?=$task['description']?>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </div>
</div>