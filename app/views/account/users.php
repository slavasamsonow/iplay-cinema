<div class="container-fluid">
    <h1>Все пользователи</h1>
    <div class="userList">
        <? foreach($users as $userItem): ?>
            <div class="user">
                <a href="/user/<?=$userItem['username']?>">
                    <div class="photo">
                        <? if(!empty($userItem['photo'])): ?>
                            <img src="/public/img/users/thumb/<?=$userItem['photo']?>"
                                 alt="<?=$userItem['fname'].' '.$userItem['lname'].' | Продюсерский центр ИГРА'?>">
                        <? endif ?>
                    </div>
                    <div class="name">
                        <?=$userItem['fname'].' '.$userItem['lname']?>
                    </div>
                </a>
            </div>
        <? endforeach ?>
    </div>
</div>
