<div class="intro">
    <div class="container-fluid">
        <div class="row topLine">
            <div class="col-md-4 offset-md-2">
                <h1>Создай <br>
                    свою <br>
                    историю</h1>
            </div>
            <div class="col-md-4 offset-md-1 eventAdv">
                <h2>
                    Веб-сериал "Игры Берна"
<!--                    <span class="date">21/11</span>-->
                </h2>
                <p>
                    интерактивный веб-сериал в формате ScreenLife
                </p>
                <a href="/project/4" class="btn btn-primary">Подробнее</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row sections">
                    <div class="col">
                        <img src="/public/img/content/logo-symbol-white.png" alt=""> <br>
                        Продакшн
                    </div>
                    <div class="col">
                        <img src="/public/img/content/logo-symbol-white.png" alt=""> <br>
                        Киношкола
                    </div>
                    <div class="col">
                        <img src="/public/img/content/logo-symbol-white.png" alt=""> <br>
                        Продюсерский центр
                    </div>
                </div>
            </div>

        </div>
        <div class="background">
            <!--            <img src="/public/img/content/background-main-intro.jpg" alt="">-->
            <!-- <video preload muted loop id="introVideo">
                <source src="/public/video/intro.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
                <source src="/public/video/intro.webm" type='video/webm; codecs="vp8, vorbis"' />
            </video> -->
            <!-- <div class="btn introplay">ПЛЭЙ</div>-->
        </div>
    </div>

</div>
<?php if(!empty($events)): ?>
    <div class="events">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h2><span class="big">Ближайшие мероприятия</span></h2>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-10 col-md-offset-1"> -->
            <?php for($i = 0; $i < count($events); $i++): ?>
                <?php if($i % 3 == 0): ?>
                    <div class="row">
                <?php endif ?>
                <div class="event col-md-4">
                    <h3>
                        <?=$events[$i]['name']?>
                        <?php if($events[$i]['noShowDate'] == 0):?>
                        <span class="date">
                        <?=date('d/m', $events[$i]['timestart'])?></span>
                        <?php endif?>
                    </h3>
                    <p>
                        <?=$events[$i]['caption']?>
                    </p>
                    <a class="btn" href="/course/<?=$events[$i]['id']?>">Записаться</a>
                </div>
                <?php if($i % 3 == 2 || $i == count($events) - 1): ?>
                    </div>
                <?php endif ?>
            <?php endfor ?>
            <!-- </div>
            </div> -->
        </div>
    </div>
<?php endif ?>
<div class="about bg-blue">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2><span class="big">О киношколе</span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 video">
                <iframe src="https://www.youtube.com/embed/6QAnXB7mbcY" frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen></iframe>
            </div>
            <div class="col-md-4">
                <h3>
                    Не мечтайте о мире кино. Действуйте!
                </h3>
                <p>
                    <q>Игра - высшая форма исследования.</q> <br>
                    <cite>Альберт Эйнштейн</cite>
                </p>
                <p>
                    С легендарным физиком-теоретиком не поспоришь: вся наша культура имеет игровую природу. Кино как
                    одно из проявлений культуры не исключение. Чем мы занимаемся в киношколе iPlay? Играем! А это
                    значит: учимся создавать кино, экспериментируем с его формами, творим, самовыражаемся, исследуем
                    мир и познаём самих себя.

                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>Ждём тех, кто: </h3>
                <p>Мечтает связать свою профессиональную деятельность с кино.</p>
                <p>Хочет получить навыки кино- и видеопроизводства. </p>
                <p>Готовится к вступительным экзаменам в вуз.</p>
                <p>Желает развиваться в своей текущей профессии.</p>
                <p>Планирует работать вне офиса и без привязки к конкретному месту.</p>
            </div>
            <div class="col-md-4">
                <h3>Вам это знакомо? </h3>
                <p>Не хватает знаний и умений.</p>
                <p>Нет заинтересованной профессиональной команды.</p>
                <p>Нет средств на воплощение задуманного.</p>
                <p>Не устраивает текущая работа.</p>
                <p>Не удаётся реализовать свой потенциал.</p>
            </div>
            <div class="col-md-4">
                <h3>В киношколе вы: </h3>
                <p>Освоите 1 из 10 кинопрофессий.</p>
                <p>Создадите свой первый фильм и реализуете творческий потенциал.</p>
                <p>Подготовитесь к вступительным экзаменам в вуз.</p>
                <p>Заведёте полезные знакомства с представителями киноиндустрии.</p>
                <p>Получите ценные знания от преподавателей-практиков.</p>
            </div>
        </div>
    </div>
</div>
<div class="courses">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2><span class="big">Курсы</span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 course">
                <h3>Интенсив шоу</h3>
                <div class="image_date">
                    <img src="/public/img/content/type_intensiv.jpg" alt="">
                    <!-- <div class="date">09/10</div> -->
                </div>

                <p>Ежемесячное мероприятие спец–формата Игры, на котором за вечер участники под руководством
                    практикующих мастеров киноиндустрии создают видеопродукт от выбора идеи до презентации результата
                    заказчику. Записывайтесь, если хотите стать соавтором реального проекта и поместить эту работу в
                    свое портфолио.</p>
                <a href="/courses?type=event" class="btn">Все мероприятия</a>
            </div>
            <div class="col-md-4 course">
                <h3>Вводный курс</h3>
                <div class="image_date">
                    <img src="/public/img/content/type_base.jpg" alt="">
                    <!-- <div class="date">09/10</div> -->
                </div>

                <p>Секреты всех этапов создания видео, обучение на реальном проекте. За месяц вы создадите свой
                    видеопродукт, попробовав на вкус 10 специальностей киноиндустрии. После обучения вы сможете снимать
                    «с нуля» ролики для своих личных и профессиональных целей.</p>
                <a href="/courses?type=basic" class="btn">Все мероприятия</a>
            </div>
            <div class="col-md-4 course">
                <h3>Основной курс</h3>
                <div class="image_date">
                    <img src="/public/img/content/type_main.jpg" alt="">
                    <!-- <div class="date">09/10</div> -->
                </div>

                <p>Рекомендуется после вводного курса. Углубленное изучение 1 из 10 киноспециальностей, позволит вам
                    освоить необходимые знания и навыки для успешного развития в выбранной профессии. Запишитесь сейчас
                    и начните свой путь к реализации на творческом поприще.</p>
                <a href="/courses?type=main" class="btn">Все мероприятия</a>
            </div>
        </div>
    </div>
</div>
<!-- <div class="lead-magnet bl-bg">
    <div class="container-fluid">
        <h2>Спешите получить<br> бесплатный вводный видео урок</h2>
        <button class="btn btn-primary">Получить</button>
    </div>
</div> -->
<div class="plus row no-gutters">

    <div class="col-md-6 order-1 plus-item">
        <div class="row no-gutters">
            <div class="col">
                <img src="/public/img/content/plus-1.jpg" alt="">
            </div>
            <div class="col">
                <div class="text">
                    Стоимость обучения в 20 раз ниже, чем в московских киношколах
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 order-3 order-md-2 plus-item">
        <div class="row no-gutters">
            <div class="col">
                <img src="/public/img/content/plus-2.jpg" alt="">
            </div>
            <div class="col">
                <div class="text">
                    Целостное представление о индустрии и других профессиях <br>(10 профессий)
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 order-2 order-md-3 plus-item">
        <div class="row no-gutters">
            <div class="col">
                <div class="text">
                    Опыт в индустрии <br>(за 3 года снято и реализовано большое количество проектов)
                </div>
            </div>
            <div class="col">
                <img src="/public/img/content/plus-3.jpg" alt="">
            </div>
        </div>
    </div>
    <div class="col-md-6 order-4 plus-item">
        <div class="row no-gutters">
            <div class="col">
                <div class="text">
                    Кураторы <br>(15 кураторов в новом сезоне)
                </div>
            </div>
            <div class="col">
                <img src="/public/img/content/plus-4.jpg" alt="">
            </div>
        </div>
    </div>
</div>
<div class="question">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2><span class="big">Задать вопрос</span></h2>
                <form action="/" method="post">
                    <input type="hidden" name="form" value="question">
                    <input type="hidden" name="page" value="Главная">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="fio" required="required"
                                       placeholder="Имя Фамилия">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" required='required'
                                       placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group form-group">
                                <textarea class="form-control" name="question" rows="5"></textarea>
                            </div>
                            <input class="btn" type="submit" value="Отправить">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<div class="modal register">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Ты первый узнаешь подробности!
    </div>
    <div class="modal-body">
        <form action="/" method="post">
            <input type="hidden" name="form" value="register">
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
            <input type="submit" class="btn" value="Записаться">
        </form>
    </div>
</div>

<div class="modal register">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Ты первый узнаешь подробности!
    </div>
    <div class="modal-body">
        <form action="/" method="post">
            <input type="hidden" name="form" value="register">
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
            <input type="submit" class="btn" value="Записаться">
        </form>
    </div>
</div>

<div>