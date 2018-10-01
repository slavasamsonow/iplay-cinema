<div class="container-fluid">
<h1><?=$userPage['fname'].' '.$userPage['lname']?></h1>
<?php if(!empty($userPage['photo'])): ?>
<img src="/public/img/users/<?=$userPage['photo']?>" alt="" width="200">
<?php else: ?>
Нет фото
<?php endif ?>
<p><?=$userPage['about']?></p>

<?php if(!empty($userPage['video'])):?>
Здесь может быть ваше видео
<? endif ?>

</div>