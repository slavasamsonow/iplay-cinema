<nav class="navbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-md-offset-1 logo">
                <a href="/">
                    <?php if(!isset($logoColor))$logoColor='black';?>
                    <img src="/public/img/content/logo-<?=$logoColor?>.png" alt="Продюсерский центр ИГРА">
                </a>
            </div>
            <div class="col-md-2">
                <? if(isset($geo['city'])): ?>
                <div class="city" style="display: inline-block;">
                    <svg viewBox="0 0 97.713 97.713">
                        <path d="M48.855,0C29.021,0,12.883,16.138,12.883,35.974c0,5.174,1.059,10.114,3.146,14.684
                                c8.994,19.681,26.238,40.46,31.31,46.359c0.38,0.441,0.934,0.695,1.517,0.695s1.137-0.254,1.517-0.695
                                c5.07-5.898,22.314-26.676,31.311-46.359c2.088-4.57,3.146-9.51,3.146-14.684C84.828,16.138,68.69,0,48.855,0z M48.855,54.659
                                c-10.303,0-18.686-8.383-18.686-18.686c0-10.304,8.383-18.687,18.686-18.687s18.686,8.383,18.686,18.687
                                C67.542,46.276,59.159,54.659,48.855,54.659z" />
                    </svg>
                    <span class="name">
                        <?=$geo['city']?>
                    </span>
                </div>
                <? endif ?>
            </div>
            <div class="col-md-6 menu_lk">
                <ul class="menu">
                    <li>
                        <a href="/news">Новости</a>
                    </li>
                </ul>
                <? if(isset($user)): ?>
                <div class="user">
                    <?php if(!empty($user['photo'])):?>
                    <span class="photo">
                        <img src="/public/img/users/thumb/<?=$user['photo']?>" alt="<?=$user['fname'].' '.$user['lname'].' | Продюсерский центр ИГРА'?>">
                    </span>
                    <?php endif ?>
                    <span class="name">
                        <?=$user['fname'].' '.$user['lname']?>
                    </span>
                    <div class="user-menu">
                        <a href="/user/<?=$user['username']?>">Моя страница</a>
                        <a href="/account" class="lk">Личный кабинет</a>
                        <a href="/account/editinfo">Редактировать профиль</a>
                        <a href="/account/editpass">Сменить пароль</a>
                        <a href="/account/logout">Выйти</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="/login">Вход</a> / <a href="/register">Регистрация</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</nav>