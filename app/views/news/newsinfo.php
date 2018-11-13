<
<div class="container-fluid">
    <h1>
        <?=$news['title']?>
    </h1>
    <div class="row">
        <? if($news['image']): ?>
            <div class="col-md-3">
                <img src="/public/img/news/<?=$news['image']?>" alt="<?=$news['name']?>">
            </div>
        <? endif ?>
        <div class="<?php echo ($news['image']) ? 'col-md-9' : 'col-md-12' ?>">
            <div>
                <?=date('d.m.Y H:i', $news['timestart'])?>
            </div>
            <div>Автор: <a href="/user/id<?=$news['authorId']?>">
                    <?=$news['author']?></a></div>
            <div class="content">
                <?=$news['content']?>
            </div>
        </div>
    </div>
    <?php if($news['image']): ?>
    <?php endif ?></
<div>