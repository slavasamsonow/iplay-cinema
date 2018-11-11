<h1>
    <?=$userPage['fname'].' '.$userPage['lname']?>
</h1>

<div class="row">
    <?php if(!empty($userPage['photo'])): ?>
        <div class="col-md-3">
            <img src="/public/img/users/<?=$userPage['photo']?>"
                 alt="<?=$userPage['fname'].' '.$userPage['lname'].' | Продюсерский центр ИГРА'?>"
                 width="200">
        </div>
    <?php endif ?>
    <div class="<?=($userPage['photo']) ? 'col-md-9' : 'col-md-12'?>">
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