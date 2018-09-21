<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$seo['title']?></title>

    <meta name="description" content="<?=$seo['description']?>">

    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">

    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/main.css">

    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/jquery.maskedinput.min.js"></script>
    <script src="/public/js/main.js"></script>

    <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter50277793 = new Ya.Metrika2({
                            id:50277793,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/tag.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks2");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/50277793" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125492467-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-125492467-1');
        </script>

</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-left">
                <a href="/">
                    <img src="/public/img/logo.png" alt="">
                </a>
            </div>
            <div class="navbar-right">
                <ul>
                    <li>
                        <a href="/login" class="lk">Личный кабинет</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="wrapper">
        <div class="container-fluid">

    <?=$content?>

        </div>
    </div>
    <footer class="transparent">
        <div class="container-fluid">
            <a href="/public/docs/protect_policy_of_personal_information.pdf" target="_blank">Политика конфеденциальности</a>
        </div>
    </footer>

    <div class="modal message">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-header"></div>
        <div class="modal-body"></div>
    </div>
    <div class="overlay"></div>
</body>
</html>