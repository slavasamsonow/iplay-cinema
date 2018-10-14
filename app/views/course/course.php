<div class="coursePage">
    <div class="headline" style="background-image: linear-gradient(to left, rgba(68, 17, 85, 0.8), rgba(68, 17, 85, 0.8)),url('/public/img/courses/foroozan-faraji-1097206-unsplash.jpg');">
        <h1>
            <span class="big">
                <?=$course['name']?>
            </span>
        </h1>
        <div class="caption">
            <?=$course['caption']?>
        </div>
        <div class="date">
            <?=date('d/m', $course['timestart'])?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="timestart">
                Дата старта:
                <?=date('d', $course['timestart'])?>
                <?
                $months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' );
                echo $months[date('n', $course['timestart'])];
                ?>
            </div>

            <?php if($course['duration'] != ''):?>
            <div class="duration">
                Продолжительность:
                <?=$course['duration']?>
            </div>

            <?php endif?>
            Уже записались: 15 человек
            <?php if($course['price'] > 0):?>
            <div class="price">
                <?=$course['price']?> Р
            </div>
            <?php endif?>
            <?php if($course['payment'] == 1):?>
            <div class="zapis">
                <a href="/pay/<?=$course['id']?>" class="btn btn-sm">Записаться</a>
            </div>
            <?php endif?>
        </div>
        <div class="col-md-8">
            <div class="description">
                <?=$course['description']?>
            </div>
        </div>
    </div>

    <?php if(!empty($teachers)):?>
    <div class="teachers">
        <h2>Преподаватели</h2>
        <div class="row">
            <?php foreach($teachers as $teacher):?>
            <div class="user col-md-4">
                <a href="/user/<?=$teacher['username']?>">
                    <div class="photo">
                        <img src="/public/img/users/thumb/<?=$teacher['photo']?>" alt="">
                    </div>
                    <div class="name">
                        <?=$teacher['fname']?> <br>
                        <?=$teacher['lname']?>
                    </div>
                </a>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>

    <?php if(!empty($curators)):?>
    <div class="courators">
        <h2>Кураторы</h2>
        <div class="row">
            <?php foreach($curators as $curator):?>
            <div class="user col-md-4">
                <a href="/user/<?=$curator['username']?>">
                    <div class="photo">
                        <img src="/public/img/users/thumb/<?=$curator['photo']?>" alt="">
                    </div>
                    <div class="name">
                        <?=$curator['fname']?> <br>
                        <?=$curator['lname']?>
                    </div>
                </a>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>

    <?php if(!empty($program )):?>
    <div class="program">
        <h2>Программа</h2>
        <p>
            <?=$course['program']?>
        </p>
        <div class="programlist">
            <ul>
                <?php foreach($program as $programItem):?>
                <li>
                    <div class="name">
                        <?=$programItem['name']?>
                    </div>
                    <div class="secription">
                        <?=$programItem['description']?>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php endif ?>
</div>