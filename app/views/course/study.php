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
    <p>Домашние задания отправляйте <a href="https://vk.com/rayproduction" target='_blank'>Ольге Мерзляковой
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
        <?php foreach($tasks as $dayName => $day):?>
        <?php
        $dayClassList = '';
        $dayCaption = '';
        if($dayName == date('d.m.Y', time())){
            $dayClassList .= 'today open';
        }

        ?>
        <div class="day <?=$dayClassList?>">
            <div class="name">
                <b>
                    <?=$dayName ?>
                </b>
                <span>Выполнено:
                    <?=$day['done']?>/
                    <?=$day['count']?>
                </span>
            </div>
            <div class="tasks-list">
                <?php foreach($day['taskslist'] as $task):?>
                <?php
                $taskClassList = '';
                if($task['active'] == 1) $taskClassList .= 'active';
                ?>
                <div class="task <?=$taskClassList?>" data-status="<?=$task['status']?>">
                    <div class="task-info">
                        <h4 class="task-name">
                            <button data-id="<?=$task['taskid']?>"></button>
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
    <h2>Проекты</h2>
    <div class="projectslist row">
        <?php foreach($projects as $project):?>
        <div class="col-md-3">
            <div class="project">
                <?php if($project['image']):?>
                <img src="/public/img/projects/<?=$project['image']?>" alt="<?=$project['name'].' | Продюсерский центр ИГРА'?>">
                <?php else: ?>
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?=$project['name'].'| Продюсерский центр ИГРА'?>">
                <?php endif?>
                <div class="name">
                    <?=$project['name']?>
                </div>
                <div class="overlay">
                    <div class="name">
                        <?=$project['name']?>
                    </div>
                    <div class="description">
                        <!-- <?=$project['caption']?> -->
                    </div>
                    <a href="/project/<?=$project['id']?>" target="_blank">Подробнее</a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <h2>Участники</h2>
    <div class="userList row">
        <? foreach($users as $userItem):?>
        <div class="user col-md-4">
            <a href="/user/<?=$userItem['username']?>">
                <div class="photo">
                    <? if(!empty($userItem['photo'])): ?>
                    <img src="/public/img/users/thumb/<?=$userItem['photo']?>" alt="<?=$userItem['fname'].' '.$userItem['lname'].' | Продюсерский центр ИГРА'?>">
                    <? endif ?>
                </div>
                <div class="name">
                    <?=$userItem['fname'].' '.$userItem['lname']?>
                </div>
            </a>
        </div>
        <? endforeach ?>
    </div>
    <?php endif?>
</div>