<div class="coursePage">
    <div class="headline" style="background-image: linear-gradient(to left, rgba(68, 17, 85, 0.8), rgba(68, 17, 85, 0.8)),url('/public/img/courses/<?=$course['image']?>');">
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
            <!-- Уже записались: <?=$course['peoples']?> -->
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
                <a href="/user/<?=$teacher['username']?>" target="_blank">
                    <div class="photo">
                        <img src="/public/img/users/thumb/<?=$teacher['photo']?>" alt="<?=$teacher['fname'].' '.$teacher['lname'].' | Продюсерский центр ИГРА'?>">
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
                <a href="/user/<?=$curator['username']?>" target="_blank">
                    <div class="photo">
                        <img src="/public/img/users/thumb/<?=$curator['photo']?>" alt="<?=$teacher['fname'].' '.$teacher['lname'].' | Продюсерский центр ИГРА'?>">
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
                    <div class="decription">
                        <?=$programItem['description']?>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php endif ?>

    <?php if(!empty($projects)):?>
    <div class="projects">
        <h2>Наши проекты</h2>
        <p>
            <?=$course['projects']?>
        </p>
        <div class="projectslist row">
            <?php foreach($projects as $project):?>
            <div class="col-md-3">
                <div class="project">
                    <?php if($project['image']):?>
                    <img src="/public/img/projects/<?=$project['image']?>" alt="<?=$project['name'].' | Продюсерский центр ИГРА'?>">
                    <?php else: ?>
                    <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?=$project['name'].'| Продюсерский центр ИГРА'?>">
                    <?php endif?>
                    <div class="name">
                        <?=$project['name']?>
                    </div>
                    <div class="overlay">
                        <div class="name">
                            <?=$project['name']?>
                        </div>
                        <div class="description">
                            <?=$project['caption']?>
                        </div>
                        <a href="/project/<?=$project['id']?>" target="_blank">Подробнее</a>
                    </div>
                </div>
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
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    Юрий Князев. Мугур
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname="Юрий Князев. Мугур" data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/iHnjb8Sp4KQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>

            <div class="portfolioItem">
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    Короткометражный фильм "Ниточка". Лена Коробейникова
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname='Короткометражный фильм "Ниточка". Лена Коробейникова'
                        data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/CfqE7Sf7pfQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>


            <div class="portfolioItem">
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    День рождение дизайнерского дуэта KATARINI
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname="День рождение дизайнерского дуэта KATARINI"
                        data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/ipoVy8EfWeA?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>

            <div class="portfolioItem">
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    Татьяна Зыкина с новым альбомом "За закрытыми окнами"
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname='Татьяна Зыкина с новым альбомом "За закрытыми окнами"'
                        data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/cgk-63V-WmQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>

            <div class="portfolioItem">
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    Новогодняя история "Чудо на Иже"
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname="Новогодняя история " Чудо на Иже""
                        data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/eqMOSruB__E?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>

            <div class="portfolioItem">
                <img src="/public/img/courses/photo-1539209826553-6d9178ca9089.jpeg" alt="<?='| Продюсерский центр ИГРА'?>">
                <div class="name">
                    Разговор о танце в Ижевске.
                </div>
                <div class="play">
                    <button data-action="modal" data-modal="video" data-videoname="Разговор о танце в Ижевске."
                        data-video='<iframe width="560" height="315" src="https://www.youtube.com/embed/TRwd0SDrQLU?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
                        class="btn btn-sm">Воспроизвести</button>
                </div>
            </div>

        </div>
    </div>

    <div class="sale">
        <div class="row">
            <div class="col-md-6">
                <h4>Акция запуск: 50% скидка</h4>
                <p>Специально для тех, кто подаст заявку и оплатит обучение до 17 октября, действует специальное
                    предложение: курс за полцены! Жмите на кнопку сейчас - успейте получить обучение по выгодной цене,
                    иначе сэкономит кто–то другой.</p>
                <p>Осталось мест: 104</p>
                <button class="btn btn-sm">Оставить заявку</button>
            </div>
            <div class="col-md-6">
                <h4>Грант на обучение: 100% скидка</h4>
                <p>Вы талант и готовы оплатить свое обучение работой над одним из проектов продюсерского центра?
                    Расскажите нам о себе, убедите, что именно вы достойны получить грант, и сэкономьте 100% стоимости
                    курса! Успейте подать заявку, количество мест ограничено.</p>
                <p>Осталось мест: 5</p>
                <? if(isset($_SESSION['user'])):?>
                <form action="<?=explode('?',$_SERVER['REQUEST_URI'])[0];?>" method="post">
                    <input type="hidden" name="form" value="grant">
                    <input type="hidden" name="course" value="<?=$course['name']?>">
                    <input type="submit" class="btn btn-sm" value="Оставить заявку">
                </form>
                <?php else: ?>
                <button class="btn btn-sm" data-action="modal" data-modal="registergrant">Оставить заявку</button>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="question">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>Задать вопрос</h2>
                <form action="<?=explode('?',$_SERVER['REQUEST_URI'])[0];?>" method="post">
                    <input type="hidden" name="form" value="question">
                    <input type="hidden" name="course" value="<?=$course['name']?>">

                    <? if(!isset($_SESSION['user'])):?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fio" required="required" placeholder="Имя Фамилия">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" required='required' placeholder="Email">
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

<div class="modal registergrant">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Заявка на грант
    </div>
    <div class="modal-body">
        <form action="<?=explode('?',$_SERVER['REQUEST_URI'])[0];?>" method="post">
            <input type="hidden" name="form" value="grant">
            <input type="hidden" name="course" value="<?=$course['name']?>">
            <div class="form-group">
                <input type="text" class="form-control" name="fio" required="required" placeholder="Имя Фамилия">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" required='required' placeholder="Email">
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="phone" required='required' placeholder="+7 (XXX) XXX-XX-XX">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="city" placeholder="Город">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required>
                    <span> Я ознакомлен и согласен <br> с <a href="/public/docs/protect_policy_of_personal_information.pdf"
                            target="_blank">Политикой конфеденциальности</a>
                    </span>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="register" value="register" checked required>
                    <span> Я хочу зарегистрироваться на сайте, <br> чтобы получить дополнительные возможности
                    </span>
                </label>
            </div>
            <input type="submit" class="btn" value="Отправить заявку">
        </form>
    </div>
</div>