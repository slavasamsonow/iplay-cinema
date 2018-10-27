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

        <?php require_once('include/favicon.php')?>
        <?php require_once('include/css_js.php')?>

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

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-125492467-1');
        </script>

        <!-- PIXEL VK -->
        <script type="text/javascript">
            ! function () {
                var t = document.createElement("script");
                t.type = "text/javascript", t.async = !0, t.src = "https://vk.com/js/api/openapi.js?159", t.onload =
                    function () {
                        VK.Retargeting.Init("VK-RTRG-290017-e59lI"), VK.Retargeting.Hit()
                    }, document.head.appendChild(t)
            }();
        </script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-290017-e59lI" style="position:fixed; left:-999px;"
                alt="" /></noscript>

    </head>

    <body>
        <div class="content">
            <?php require_once('include/navbar.php')?>

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 left-menu">
                            <?php require_once('include/left-menu.php')?>
                        </div>
                        <div class="col-md-8 col-sm-6">
                            <?=$content?>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div class="container-fluid">
                    <a href="/public/docs/protect_policy_of_personal_information.pdf" target="_blank">Политика
                        конфеденциальности</a>
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