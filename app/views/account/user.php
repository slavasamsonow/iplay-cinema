<h1>
    <?=$userPage['fname'].' '.$userPage['lname']?>
</h1>

<div class="row">
    <?php if(!empty($userPage['photo'])): ?>
    <div class="col-md-3">
        <img src="/public/img/users/<?=$userPage['photo']?>" alt="" width="200">
    </div>
    <div class="col-md-9">
        <?php else: ?>
        <div class="col-md-12">
            <?php endif ?>
            <p>
                <?=$userPage['about']?>
            </p>
        </div>
    </div>