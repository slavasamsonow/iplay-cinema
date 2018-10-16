<h1>
    <?=$project['name']?>
</h1>
<div class="row">
    <? if($project['image']):?>
    <div class="col-md-3">
        <img src="/public/img/projects/<?=$project['image']?>" alt="<?=$project['name']?>">
    </div>
    <? endif ?>
    <div class="<?php echo ($project['image'])?'col-md-9':'col-md-12'?>">
        <div class="date-start">
            <?=date('d.m.Y',$project['timestart'])?>
        </div>
        <div class="creator">Создатель:
            <a href="/user/id<?=$project['creatorid']?>">
                <?=$project['creatorfname'].' '.$project['creatorlname']?>
            </a>
        </div>
        <div class="description">
            <?=$project['description']?>
        </div>
    </div>
</div>
<?php if($project['video']): ?>
<h2>Видео</h2>
<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$project['video']?>?rel=0&amp;controls=0&amp;showinfo=0"
    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
<?php endif ?>