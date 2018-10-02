<h1>Все пользователи</h1>
<? foreach($users as $userItem):?>
<div class="user">
    <a href="/user/<?=$userItem['username']?>">
        <div class="name">
            <?=$userItem['fname'].' '.$userItem['lname']?>
        </div>
    </a>
</div>
<? endforeach ?>