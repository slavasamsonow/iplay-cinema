<div class="hello-message">
    <h2> Добро пожаловать,
        <?=$user['fname']?>
    </h2>
    Для ознакомления с системой, вам нужно пройти курс "Знакомство"
</div>
<div class="courses">
    <?php if(count($activeCourses) > 0):?>
    <h2><span class="big">Мои курсы</span></h2>
    <div class="row">
        <?php foreach($activeCourses as $course): ?>
        <div class="col-lg-4 col-sm-6 course">
            <h3>
                <?=$course['name']?>
            </h3>
            <p>
                <?=$course['description']?>
            </p>
            <div class="progress">
                <div class="progress-bar" style="width: <?=$course['percent']?>%">
                    <span class="sr-only">Прогресс:
                        <?=$course['percent']?> %</span>
                </div>
            </div>
            <a href="/study/<?=$course['id']?>" class="btn btn-default btn-sm">Открыть</a>
        </div>
        <? endforeach ?>
    </div>
    <?php else:?>
    Сейчас у вас нет активных курсов
    <?php endif ?>
</div>