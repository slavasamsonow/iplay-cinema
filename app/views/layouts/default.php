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
<div class="wrapper">
    <?php require_once('include/left-menu.php') ?>
    <?php require_once('include/navbar.php') ?>

    <div class="content">
        <div class="container-fluid">
            <?=$content?>
        </div>
    </div>

    <?php require_once('include/footer_default.php') ?>
</div>

<div class="process-load">
    <div class="right-top">
        <img src="/public/img/load.svg" alt="">
    </div>
</div>
</body>

</html>