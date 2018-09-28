<div class="container-fluid">
<h1><?=$userPage['fname'].' '.$userPage['lname']?></h1>
<p><?=$userPage['about']?></p>

<?php if(!empty($userPage['video'])):?>
Здесь может быть ваше видео
<? endif ?>

</div>