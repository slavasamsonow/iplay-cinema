<h1><span class="big">Новости</span></h1>
<?php foreach($newslist as $newsitem): ?>
    <div class="newsitem">
        <h2><?=$newsitem['title']?></h2>
        <div><?=date('d.m.Y H:i', $newsitem['timestart'])?></div>
        <div><?=$newsitem['caption']?></div>
        <a href="/news/<?=$newsitem['id']?>" class="btn btn-sm">Читать</a>
    </div>

<?php endforeach ?>