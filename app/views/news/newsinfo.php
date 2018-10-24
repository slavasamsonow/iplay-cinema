<h1><?=$news['title']?></h1>
<div><?=date('d.m.Y H:i',$news['timestart'])?></div>
<div>Автор: <a href="/user/id<?=$news['authorId']?>"><?=$news['author']?></a></div>
<div class="content"><?=$news['content']?></div>