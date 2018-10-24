<h1><?=$news['title']?></h1>
<div><?=date('d.m.Y H:i',$news['timestart'])?></div>
<div>Автор: <a href="/user/id<?=$news['authorId']?>"><?=$news['authorFname'].' '.$news['authorLname']?></a></div>
<div class="content"><?=$news['content']?></div>