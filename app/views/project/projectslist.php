<div class="container-fluid">
    <h1><span class="big">Проекты</span></h1>
    <?php if(!empty($projects)): ?>
        <div class="projects row">
            <?php foreach($projects as $project): ?>
                <div class="project col-md-4">
                    <h2>
                        <?=$project['name']?>
                    </h2>
                    <div class="date-start">
                        <?=date('d.m.Y', $project['timestart'])?>
                    </div>
                    <div class="creator">Создатель:
                        <a href="/user/id<?=$project['creatorid']?>">
                            <?=$project['creatorfname'].' '.$project['creatorlname']?>
                        </a>
                    </div>
                    <div class="description">
                        <?=$project['caption']?>
                    </div>
                    <a href="/project/<?=$project['id']?>" class="btn btn-default btn-sm">Подробнее</a>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        На данный момент нет активых проектов
    <?php endif ?></div>