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

        <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">

        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/main.css?v=2.1.3">
        <link rel="stylesheet" href="/public/css/media.css?v=2.1.3">

        <script src="/public/js/jquery.js"></script>
        <script src="/public/js/jquery.maskedinput.min.js"></script>
        <script src="/public/js/main.js?v=2.1.3"></script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function () {
                    try {
                        w.yaCounter50277793 = new Ya.Metrika2({
                            id: 50277793,
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true,
                            webvisor: true
                        });
                    } catch (e) {}
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () {
                        n.parentNode.insertBefore(s, n);
                    };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/tag.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks2");
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/50277793" style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125492467-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-125492467-1');
        </script>

        <!-- PIXEL VK -->
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?159",t.onload=function(){VK.Retargeting.Init("VK-RTRG-290017-e59lI"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-290017-e59lI" style="position:fixed; left:-999px;" alt=""/></noscript>

    </head>

    <body>
        <div class="content">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-left">
                        <? if(isset($geo['city'])): ?>
                        <div class="city">
                            <svg viewBox="0 0 97.713 97.713">
                                <path d="M48.855,0C29.021,0,12.883,16.138,12.883,35.974c0,5.174,1.059,10.114,3.146,14.684
                                c8.994,19.681,26.238,40.46,31.31,46.359c0.38,0.441,0.934,0.695,1.517,0.695s1.137-0.254,1.517-0.695
                                c5.07-5.898,22.314-26.676,31.311-46.359c2.088-4.57,3.146-9.51,3.146-14.684C84.828,16.138,68.69,0,48.855,0z M48.855,54.659
                                c-10.303,0-18.686-8.383-18.686-18.686c0-10.304,8.383-18.687,18.686-18.687s18.686,8.383,18.686,18.687
                                C67.542,46.276,59.159,54.659,48.855,54.659z" />
                            </svg>
                            <span class="name">
                                <?=$geo['city']?>
                            </span>
                        </div>
                        <? endif ?>

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
                <?=$content?>
            </div>

            <footer>
                <div class="container-fluid">
                    <div class="col-md-3">
                        &#169; Киношкола iPlay, 2015-<?=date('Y', time())?> <br>
                        <a href="mailto:videolab.play@gmail.com">videolab.play@gmail.com</a>
                    </div>
                    <div class="col-md-3 col-md-offset-3">
                        <a href="/public/docs/protect_policy_of_personal_information.pdf" target="_blank">Политика
                            конфеденциальности</a>
                        <hr>
                        ИП Муратова Татьяна Сергеевна <br>
                        ИНН 183402585126 <br>
                        ОГРНИП 310184015100083
                    </div>
                </div>
            </footer>
        </div>

        <div class="modal message">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-header"></div>
            <div class="modal-body"></div>
        </div>
        <div id="overlay"></div>

        <div class="process-load">
            <div class="right-top">
                <img src="/public/img/load.svg" alt="">
            </div>
        </div>
    </body>

</html>