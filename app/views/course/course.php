<div class="coursePage">
    <div class="headline" style="<?php if($course['image']){
        echo 'background-image: url(/public/img/courses/'.$course['image'].')';
    } ?>">
        <div class="row">
            <div class="col-md-8">
                <h1>
                    <span class="big">
                        <?=$course['name']?>
                    </span>
                </h1>
                <div class="caption">
                    <?=$course['caption']?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="date">
                    Дата старта: <br>
                    <?=date('d', $course['timestart'])?>
                    <?
                    $months = array(1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
                    echo $months[date('n', $course['timestart'])];
                    ?>
                </div>
                <?php if($course['payment'] == 1): ?>
                    <div class="zapis">
                        <?php if(isset($_SESSION['user'])): ?>
                            <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
                                <input type="hidden" name="form" value="registercourse">
                                <input type="hidden" name="courseid" value="<?=$course['id']?>">
                                <input type="hidden" name="course" value="<?=$course['name']?>">
                                <input type="submit" class="btn btn-primary" value="Записаться">
                            </form>
                        <?php else: ?>
                            <button class="btn btn-primary" data-action="modal" data-modal="registercourse">Записаться
                            </button>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

    <?php if($course['id'] == 4): ?>
        <div class="all">
            <a class="btn btn-primary" href="/lending/intensiv"> Более подробная информация</a>
        </div>
    <?php endif ?>

    <div class="description">
        <?=$course['description']?>
        <div class="background-triangles">
            <img src="/public/img/content/pattern-more-triangle-blue.svg" alt="">
        </div>
    </div>


    <?php if(!empty($teachers)): ?>
        <div class="teachers">
            <h2>Преподаватели</h2>
            <div class="row">
                <?php foreach($teachers as $teacher): ?>
                    <div class="user col-md-4">
                        <a href="/user/<?=$teacher['username']?>" target="_blank">
                            <div class="photo">
                                <img src="/public/img/users/thumb/<?=$teacher['photo']?>"
                                     alt="<?=$teacher['fname'].' '.$teacher['lname'].' | Продюсерский центр ИГРА'?>">
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

    <?php if(!empty($curators)): ?>
        <div class="courators">
            <h2>Кураторы</h2>
            <div class="row">
                <?php foreach($curators as $curator): ?>
                    <div class="user col-md-4">
                        <a href="/user/<?=$curator['username']?>" target="_blank">
                            <div class="photo">
                                <img src="/public/img/users/thumb/<?=$curator['photo']?>"
                                     alt="<?=$teacher['fname'].' '.$teacher['lname'].' | Продюсерский центр ИГРА'?>">
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

    <?php if(!empty($program)): ?>
        <div class="program">
            <h2>Программа:</h2>
            <?php if($course['program']): ?>
                <p>
                    <?=$course['program']?>
                </p>
            <?php endif ?>
            <div class="programlist">
                <ul>
                    <?php foreach($program as $programItem): ?>
                        <li>
                            <div class="name">
                                <?=$programItem['name']?>
                            </div>
                            <div class="decription">
                                <?=$programItem['description']?>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif ?>

    <?php if(!empty($projects)): ?>
        <div class="projects bg-purple white-text">
            <h2>Наши проекты</h2>
            <p>
                <?=$course['projects']?>
            </p>
            <div class="projectslist owl-carousel">
                <?php foreach($projects as $project): ?>
                    <div class="project">
                        <?php if($project['image']): ?>
                            <img src="/public/img/projects/<?=$project['image']?>"
                                 alt="<?=$project['name'].' | Продюсерский центр ИГРА'?>">
                        <?php else: ?>
                            <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg"
                                 alt="<?=$project['name'].'| Продюсерский центр ИГРА'?>">
                        <?php endif ?>
                        <div class="name">
                            <a href="/project/<?=$project['id']?>" target="_blank">
                                <?=$project['name']?></a>
                        </div>
                        <!-- <div class="overlay">
                    <div class="name">
                        <?=$project['name']?>
                    </div>
                    <div class="description">
                        <?=$project['caption']?>
                    </div>
                    <a href="/project/<?=$project['id']?>" target="_blank">Подробнее</a>
                </div> -->
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <div class="portfolio">
        <h2>Работы наших выпускников</h2>
        <p>
            <?=$course['portfolio']?>
        </p>
        <div class="portfoliolist row owl-carousel">
            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/mugur.png"
                         alt="<?='Юрий Князев. Мугур | Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video" data-videoname="Юрий Князев. Мугур"
                                data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/iHnjb8Sp4KQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                                class="btn btn-sm">Воспроизвести
                        </button>
                    </div>
                </div>

                <div class="name">
                    Юрий Князев. Мугур
                </div>

            </div>

            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/nitochka.png" alt="<?='Короткометражный фильм " Ниточка". Лена
                        Коробейникова | Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video"
                                data-videoname='Короткометражный фильм "Ниточка". Лена Коробейникова'
                                data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/CfqE7Sf7pfQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                                class="btn btn-sm">Воспроизвести
                        </button>
                    </div>
                </div>

                <div class="name">
                    Короткометражный фильм "Ниточка". Лена Коробейникова
                </div>

            </div>


            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/katarini.png"
                         alt="<?='День рождение дизайнерского дуэта KATARINI | Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video"
                                data-videoname="День рождение дизайнерского дуэта KATARINI"
                                data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/ipoVy8EfWeA?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                                class="btn btn-sm">Воспроизвести
                        </button>
                    </div>
                </div>
                <div class="name">
                    День рождение дизайнерского дуэта KATARINI
                </div>
            </div>

            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/Tatyana-zikina.png" alt="<?='Татьяна Зыкина с новым альбомом " За
                        закрытыми окнами" | Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video"
                                data-videoname='Татьяна Зыкина с новым альбомом "За закрытыми окнами"'
                                data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/cgk-63V-WmQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                                class="btn btn-sm">Воспроизвести
                        </button>
                    </div>
                </div>
                <div class="name">
                    Татьяна Зыкина с новым альбомом "За закрытыми окнами"
                </div>
            </div>

            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/chidu-na-izhe.png" alt="<?='Новогодняя история " Чудо на Иже" |
                        Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video" data-videoname="Новогодняя история " Чудо на
                                Иже
                        "" data-video='
                        <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/eqMOSruB__E?rel=0&amp;controls=0&amp;showinfo=0"
                                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        '
                        class="btn btn-sm">Воспроизвести</button>
                    </div>
                </div>
                <div class="name">
                    Новогодняя история "Чудо на Иже"
                </div>
            </div>

            <div class="portfolioItem">
                <div class="image">
                    <img src="/public/img/portfolio/razgovor-o-tancah.png"
                         alt="<?='Разговор о танце в Ижевске. | Продюсерский центр ИГРА'?>">
                    <div class="play">
                        <button data-action="modal" data-modal="video" data-videoname="Разговор о танце в Ижевске."
                                data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/TRwd0SDrQLU?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                                class="btn btn-sm">Воспроизвести
                        </button>
                    </div>
                </div>
                <div class="name">
                    Разговор о танце в Ижевске.
                </div>
            </div>

        </div>
    </div>

    <?php if($course['id'] != 4): ?>
        <div class="sale bg-red">
            <div class="row">
                <!-- <div class="col-md-6">
                    <h4>Акция запуск: 50% скидка</h4>
                    <p>Специально для тех, кто подаст заявку и оплатит обучение до 17 октября, действует специальное
                        предложение: курс за полцены! Жмите на кнопку сейчас - успейте получить обучение по выгодной цене,
                        иначе сэкономит кто–то другой.</p>
                    <p>Осталось мест: 104</p>
                    <button class="btn btn-sm">Оставить заявку</button>
                </div> -->
                <div class="col-md-6">
                    <h4>Грант на обучение: 100% скидка</h4>
                    <p>Вы талант и готовы оплатить свое обучение работой над одним из проектов продюсерского центра?
                        Расскажите нам о себе, убедите, что именно вы достойны получить грант, и сэкономьте 100%
                        стоимости
                        курса! Успейте подать заявку, количество мест ограничено.</p>
                    <div class="ostatok">Осталось мест: 5</div>
                    <? if(isset($_SESSION['user'])): ?>
                        <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
                            <input type="hidden" name="form" value="registergrant">
                            <input type="hidden" name="course" value="<?=$course['name']?>">
                            <input type="submit" class="btn btn-sm" value="Оставить заявку">
                        </form>
                    <?php else: ?>
                        <button class="btn btn-sm" data-action="modal" data-modal="registergrant">Оставить заявку
                        </button>
                    <?php endif ?>
                </div>
            </div>
            <div class="background-triangles">
                <img src="/public/img/content/pattern-more-triangle-white.svg" alt="">
            </div>
        </div>
    <?php endif ?>

    <div class="question">
        <div class="row">
            <div class="col-md-6">
                <h2>Задать вопрос</h2>
                <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
                    <input type="hidden" name="form" value="question">
                    <input type="hidden" name="page" value="Курс <?=$course['name']?>">

                    <? if(!isset($_SESSION['user'])): ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fio" required="required"
                                   placeholder="Имя Фамилия">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" required='required'
                                   placeholder="Email">
                        </div>
                    <?php endif ?>

                    <div class="control-group form-group">
                        <textarea class="form-control" name="question" rows="5"></textarea>
                    </div>
                    <input class="btn" type="submit" value="Отправить">
                </form>
            </div>
        </div>

    </div>
</div>

</div>
</div>

<div class="modal video">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Видео
    </div>
    <div class="modal-body">
    </div>
</div>

<div class="modal registercourse">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Заявка на курс
    </div>
    <div class="modal-body">
        <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
            <input type="hidden" name="form" value="registercourse">
            <input type="hidden" name="course" value="<?=$course['name']?>">
            <input type="hidden" name="courseid" value="<?=$course['id']?>">
            <div class="form-group">
                <input type="text" class="form-control" name="fio" required="required" placeholder="Имя Фамилия">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" required='required' placeholder="Email">
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="phone" required='required'
                       placeholder="+7 (XXX) XXX-XX-XX">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="city" placeholder="Город">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required>
                    <span> Я ознакомлен и согласен <br> с <a
                                href="/public/docs/protect_policy_of_personal_information.pdf"
                                target="_blank">Политикой конфеденциальности</a>
                    </span>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="register" value="register" checked>
                    <span> Я хочу зарегистрироваться на сайте, <br> чтобы получить дополнительные возможности
                    </span>
                </label>
            </div>
            <input type="submit" class="btn" value="Отправить заявку">
        </form>
    </div>
</div>

<div class="modal registergrant">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Заявка на грант
    </div>
    <div class="modal-body">
        <form action="<?=explode('?', $_SERVER['REQUEST_URI'])[0];?>" method="post">
            <input type="hidden" name="form" value="registergrant">
            <input type="hidden" name="course" value="<?=$course['name']?>">
            <div class="form-group">
                <input type="text" class="form-control" name="fio" required="required" placeholder="Имя Фамилия">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" required='required' placeholder="Email">
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="phone" required='required'
                       placeholder="+7 (XXX) XXX-XX-XX">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="city" placeholder="Город">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required>
                    <span> Я ознакомлен и согласен <br> с <a
                                href="/public/docs/protect_policy_of_personal_information.pdf"
                                target="_blank">Политикой конфеденциальности</a>
                    </span>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="register" value="register" checked>
                    <span> Я хочу зарегистрироваться на сайте, <br> чтобы получить дополнительные возможности
                    </span>
                </label>
            </div>
            <input type="submit" class="btn" value="Отправить заявку">
        </form>
    </div>
</div>

<div>
    <div>