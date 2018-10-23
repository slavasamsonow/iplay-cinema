<h1><span class="big">Проекты</span></h1>
<a href="/admin/addproject" class="btn">Создать новый проект</a>
<?php if(!empty($projects)): ?>
<div class="projects">
    <?php for($i = 0; $i < count($projects); $i++): ?>
    <?php if($i % 3 == 0):?>
    <div class="row">
        <?php endif ?>
        <div class="project col-md-4">
            <h2>
                <?=$projects[$i]['name']?>
            </h2>
            <div class="date-start">
                Дата создания:
                <?=date('d.m.Y',$projects[$i]['timestart'])?>
            </div>
            <div class="creator">Создатель:
                <a href="/user/id<?=$projects[$i]['creatorid']?>">
                    <?=$projects[$i]['creatorfname'].' '.$projects[$i]['creatorlname']?>
                </a>
            </div>
            <div class="description">
                <?=$projects[$i]['caption']?>
            </div>
            <a href="/project/<?=$projects[$i]['id']?>" class="btn btn-default btn-sm">Подробнее</a>
            <a href="/admin/editproject/<?=$projects[$i]['id']?>" class="btn btn-default btn-sm">Редактировать</a>
        </div>
        <?php if($i % 3 == 2):?>
    </div>
    <?php endif ?>
    <?php endfor?>
</div>
<?php else: ?>
На данный момент нет проектов
<?php endif?>