<h1>
    <?=$project['name']?>
</h1>
<div class="row">
    <? if(isset($project['image'])):?>
    <div class="col-md-3"><img src="/public/img/projects/<?=$project['image']?>" alt="<?=$project['name']?>">
    </div>
    <div class="col-md-9">
        <? else: ?>
        <div class="col-md-12">
            <? endif ?>
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