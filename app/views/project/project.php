<h1>
    <?=$project['name']?>
</h1>
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