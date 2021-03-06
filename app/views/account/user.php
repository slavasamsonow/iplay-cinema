<div class="container-fluid">
    <h1>
        <?=$userPage['fname'].' '.$userPage['lname']?>
    </h1>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
        <p>
            <small>
                <a href="/admin/edituser/id<?=$userPage['id']?>">Редактировать</a>
            </small>
        </p>

    <?php endif ?>

    <div class="row">
        <div class="col-md-3">
            <?php if(!empty($userPage['photo'])): ?>
                <img src="/public/img/users/<?=$userPage['photo']?>"
                     alt="<?=$userPage['fname'].' '.$userPage['lname'].' | Продюсерский центр ИГРА'?>"
                     width="200" style="margin-bottom: 20px;">
            <?php endif ?>

            <?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] != $userPage['id']): ?>
            <div>
                <button class="btn btn-sm">Написать сообщение</button>
            </div>
            <?php endif ?>
        </div>
        <div class="col-md-9">
            <?php if(!$userPage['public'] && !isset($_SESSION['user'])): ?>
                Пользователь ограничил доступ к информации
            <?php else: ?>
                <?php if($userPage['city']): ?>
                    <div class="city">
                        Город: <?=$userPage['city']?>
                    </div>
                <?php endif ?>
                <div class="about">
                    <?=$userPage['about']?>
                </div>
                <?php if(!empty($userProjects)): ?>
                    <div class="projects">
                        <h2>Проекты:</h2>
                        <?php foreach($userProjects as $userProject): ?>
                            <div class="project">
                                <a href="/project/<?=$userProject['id']?>">
                                    <?=$userProject['name']?></a>
                            </div>

                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>
