<div class="container-fluid">
    <h1>Все пользователи</h1>
    <? foreach($users as $user):?>
        <div class="user">
            <div class="name"><?=$user['fname'].' '.$user['lname']?></div>
        </div>
    <? endforeach ?>
</div>