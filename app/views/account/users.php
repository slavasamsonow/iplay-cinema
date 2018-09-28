<div class="container-fluid">
    <h1>Все пользователи</h1>
    <? foreach($users as $user):?>
    <div class="user">
        <a href="/user/<?=$user['username']?>">
            <div class="name">
                <?=$user['fname'].' '.$user['lname']?>
            </div>
        </a>
    </div>
    <? endforeach ?>
</div>