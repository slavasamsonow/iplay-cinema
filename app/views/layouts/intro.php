<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?=$seo['title']?>
    </title>

    <meta name="description" content="<?=$seo['description']?>">

    <?php require_once('include/favicon.php') ?>
    <?php require_once('include/css_js.php') ?>

    <?php require_once('include/yandexmetrika.php') ?>
    <?php require_once('include/googleanalitics.php') ?>
    <?php require_once('include/pixelvk.php') ?>

</head>

<body>
<div class="wrapper intro-wrapper">
    <?php
    $logoColor = 'white';
    require_once('include/navbar.php')
    ?>

    <div class="content">
        <?=$content?>
    </div>

    <footer>
        <div class="container-fluid">
            <a href="/public/docs/protect_policy_of_personal_information.pdf" target="_blank">Политика
                конфеденциальности</a>
        </div>
    </footer>
    <div id="overlay"></div>
    <div class="modal message">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-header"></div>
        <div class="modal-body"></div>
    </div>

    <div class="modal leadMagnet">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <p><b>Хочешь узнать, кто ты на съемочной площадке? Самовлюбленный актер, идейный сценарист или злой
                    режиссер?</b></p>
            <p style="text-align: center;"><a href="/tests/yourprofession" class="btn btn-default">Кликай сюда</a></p>
        </div>
    </div>
    <script>
        function openModal(type, header, body) {
            $('.modal').fadeOut(300);
            if (header != undefined) {
                $('.modal.' + type + ' .modal-header').html(header);
            }
            if (body != undefined) {
                $('.modal.' + type + ' .modal-body').html(body);
            }
            $('body').addClass('modalopen');
            $('.modal.' + type).fadeIn(300);
            $('#overlay').fadeIn(300);
        }

        <?php if(!isset($_SESSION['leadMagnet'])): ?>
        <?php $_SESSION['leadMagnet'] = true; ?>
        $(document).ready(function () {
            setTimeout(function () {
                openModal('leadMagnet')
            }, 12000);
        })
        <?php endif ?>
    </script>
</div>

<div class="process-load">
    <div class="right-top">
        <img src="/public/img/load.svg" alt="">
    </div>
</div>
</body>

</html>