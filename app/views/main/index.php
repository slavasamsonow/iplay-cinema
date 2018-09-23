<div class="intro">
    <div class="container-fluid ">
        <div class="row title">
            <div class="col-md-9 col-md-offset-1 ">
                <h1>Такого еще не было!</h1>
            </div>
        </div>
        <div class="row body">
            <div class="col-md-5 col-md-offset-1 description">
                <div class="text">
                    На Ваших глазах <br> и с Вашим участием <br>эксперты кино и видеоиндустрии <br>создадут фильм!
                </div>
                <div class="bitton">
                    <?php if(isset($_SESSION['user']['id'])):?>
                    <a href="account" class="btn">Перейти в личный кабинет</a>
                    <? else:?>
                    <button class="btn" data-action="modal" data-modal="register">Узнать больше</button>
                    <? endif ?>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-2 data-place">
                <div class="place">
                    Главный кинотеатр Москвы <br> КАРО ОКТЯБРЬ
                </div>
                <div class="date">
                    9 октября / 18
                </div>
            </div>
        </div>
    </div>
    <div class="background">
        <!-- <img src="/public/img/back.png" alt=""> -->
        <video preload id="introVideo">
            <source src="/public/video/intro.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
            <source src="/public/video/intro.webm" type='video/webm; codecs="vp8, vorbis"' />
        </video>
        <div class="btn introplay">ПЛЭЙ</div>
        <div class="video-shape">
            <div class="left-screen"></div>
            <svg viewbox="0 0 3 9" class="left">
                <polygon points="0,0 3,0 3,9 0,9" />
            </svg>
            <svg viewbox="0 0 7 10" class="right">
                <polygon points="0,0 7,5 0,10 7,10 7,0" />
            </svg>
            <div class="right-screen">

            </div>
        </div>
        <svg class="big-left-triangle" viewbox="0 0 17 13">
            <polygon points="0,8 11,0 17,0 17,13 7,13" />
        </svg>
        <svg class="big-right-triangle" viewbox="0 0 6 4">
            <polygon points="0,4 6,0 6,4" />
        </svg>
        <img class="more-triangle" src="/public/img/pattern-more-triangle.svg" alt="">
    </div>

    <!-- <?php if(isset($_SESSION['user']['id'])):?>
            <a href="account">Перейти в личный кабинет</a>
        <? else:?>
            <button data-action="modal" data-modal="register">Записаться</button>
        <? endif ?> -->
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
                <input type="tel" class="form-control" name="phone" required='required' placeholder="+7 (XXX) XXX-XX-XX">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required>
                    <span> Я ознакомлен и согласен <br> с <a href="/public/docs/protect_policy_of_personal_information.pdf"
                        target="_blank">Политикой конфеденциальности</a>
</span>
                </label>
            </div>
            <input type="submit" class="btn" value="Записаться">
        </form>
    </div>
</div>