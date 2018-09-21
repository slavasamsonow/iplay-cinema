<h1>
    <?php if(isset($user['fname']) || isset($user['lname'])){
        echo $user['fname'].' '.$user['lname'];
    }elseif(isset($user['username'])){
        echo $user['username'];
    }else{
        echo $user['email'];
    }?>
    <small>(уровень: <?=$user['level']?>)</small>
</h1>
<div class="row">
    <div class="col-md-2">
        <a href="/account/editpass">Сменить пароль</a> <br>
        <a href="/account/logout">Выйти</a>
    </div>
    <div class="col-md-8">
        Для повышения уровня вам нужно проходить курсы:
        <div class="row courses">
            <?php if(count($activeCourses) > 0):?>
                <?php foreach($activeCourses as $course): ?>
                    <div class="col-md-3 course">
                        <h3><?=$course['name']?></h3>
                        <p><?=$course['description']?></p>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?=$course['percent']?>%">
                                <span class="sr-only">Прогресс: <?=$course['percent']?> %</span>
                            </div>
                        </div>
                        <a href="/study/<?=$course['id']?>" class="btn btn-default">Открыть</a>
                    </div>
                <? endforeach ?>
            <?php else:?>
                Сейчас у вас нет активных курсов
            <?php endif ?>
        </div>
    </div>

</div>