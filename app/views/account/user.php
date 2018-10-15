<h1>
    <?=$userPage['fname'].' '.$userPage['lname']?>
</h1>

<div class="row">
    <?php if(!empty($userPage['photo'])): ?>
    <div class="col-md-3">
        <img src="/public/img/users/<?=$userPage['photo']?>" alt="<?=$userPage['fname'].' '.$userPage['lname'].' | Продюсерский центр Игра'?>" width="200">
    </div>
    <div class="col-md-9">
        <?php else: ?>
        <div class="col-md-12">
            <?php endif ?>
            <div class="about"><?=$userPage['about']?></div>
            <div class="projects">
            <h2>Проекты:</h2>
            <?php foreach($userProjects as $userProject):?>
                <a href="/project/<?=$userProject['id']?>"><?=$userProject['name']?></a>
            <?php endforeach ?>
            </div>

        </div>
    </div>
