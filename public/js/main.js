// v.0.18.0

$(document).ready(function () {
    function videoHeight() {
        $('.video iframe').each(function () {
            var widthVideo = $(this).width();
            var heightVideo = widthVideo / 16 * 9;
            $(this).css('height', heightVideo);
        });
    }

    function minHeightContent() {
        // Для блока интро
        var headerHeight = $('nav.navbar').height();
        var footerHeight = $('footer').height();
        var windowHeight = $(window).height();
        $('.content .intro').css('padding-top', headerHeight + 'px');

        // Минимальная высота сайта
        if (!$('.content.intro').length) {
            var minHeight = windowHeight - headerHeight - footerHeight;
            $('.content').css('min-height', minHeight + 'px');
            $('footer').removeClass('load');
        }
    }

    minHeightContent();

    // Выпадающее меню юзера
    $('.navbar .user').click(function () {
        var userController = $(this);
        userController.toggleClass('active');
        $('.navbar .user .user-menu').slideToggle();
        userController.mouseleave(function () {
            var closeUsercontroller = setTimeout(function () {
                userController.removeClass('active');
                $('.navbar .user .user-menu').slideUp();
            }, 500)
            userController.mouseenter(function () {
                clearTimeout(closeUsercontroller);
            })
        })
    })

    // Левое меню
    $('.left-menu .parent span').click(function () {
        $(this).parent().children('ul').slideToggle();
    })

    var thisPageFull = document.location.pathname + document.location.search;
    $('a[href="' + thisPageFull + '"]').addClass('thisPage');
    var thisPage = document.location.pathname;
    $('.left-menu a[href="' + thisPage + '"]').addClass('thisParent');
    $('.mobile-menu a[href="' + thisPage + '"]').addClass('thisParent');

    // Маски ввода
    $("input[type=tel]").mask("+7 (999) 999-99-99");
    $("input[name=datetime]").mask('99.99.9999 99:99:99');
    $("input[name=timestart]").mask('99.99.9999 99:99:99');
    $("input[name=timeend]").mask('99.99.9999 99:99:99');

    $('form').submit(function (event) {
        if ($(this).hasClass('no_ajax')) {
            return;
        }
        var json;
        event.preventDefault();
        $('.process-load').show();
        $('.process-load').addClass('active');
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.url) {
                    window.location.href = '/' + json.url;
                } else if (json.urlo) {
                    window.location.href = json.urlo;
                } else if (json.modal == 'modalmessage') {
                    openModal('message', json.modalheader, json.modalbody);
                }
                $('.process-load').removeClass('active');
                $('.process-load').hide();
            },
        });
    });

    // Модальные окна
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

    $("#overlay").click(function () {
        $(".modal").hide();
        $("#overlay").hide();
        $("body").removeClass('modalopen');
    })
    $(".modal .close").click(function () {
        $(this).parent().hide();
        $("#overlay").hide();
        $("body").removeClass('modalopen');
    })
    $("button[data-action='modal']").click(function () {
        var modal = $(this).data('modal');
        $('.modal.' + modal).show();
        $('#overlay').show();
    })

    $("button[data-modal='video']").click(function () {
        var videoName = $(this).data('videoname');
        $('.modal.video .modal-header').html(videoName);
        var videoDescription = $(this).data('videodescription');
        $('.modal.video .modal-body .description').html(videoDescription);
        var video = $(this).data('video');
        $('.modal.video .modal-body .video').html(video);
    })


    if ($('#introVideo').length) {
        var introvideo = $("#introVideo")[0];
        var durationTrue = setInterval(function () {
            var duration = introvideo.duration;
            if (duration) {
                clearInterval(durationTrue);
                startIntroVideo(introvideo);
            }
        }, 100)

        function startIntroVideo(introvideo) {
            $('.intro .background .video-shape').addClass('end');
            introvideo.play();

            setTimeout(function () {
                $('.intro .background .video-shape').addClass('out');
                $('.intro .background .big-left-triangle').addClass('left');
            }, 3000)
        }
    }

    if ($('.lending-intro-content').length && $(window).width() > 767) {
        var headerHeight = $('.lending-intro .top').outerHeight();
        var baseHeight = $('.lending-intro-content').outerHeight();
        var windowHeight = $(window).height();
        var newPaddingBottom = Math.floor((windowHeight - headerHeight - baseHeight) / 2);
        $('.lending-intro .top').css('margin-bottom', newPaddingBottom);
    }


    $('.tasks .day .name').click(function () {
        $(this).next('.tasks-list').slideToggle();
        $(this).parent().toggleClass('open');
    });
    $('.tasks .day.today').children('.tasks-list').slideDown();
    // Взаимодействие с заданием курса
    $('.tasks .task.active button').click(function () {
        var elem = $(this);
        var parent = elem.closest('.task');
        var comment = parent.find('.task-comment');
        var errorText = parent.find('.task-error');
        if (parent.hasClass('process')) {
            return;
        }
        var taskId = Number(elem.attr('data-id'));

        parent.addClass('process');
        $.ajax({
            url: '/study/checkTask',
            type: 'post',
            data: 'task=' + taskId,
            success: function (result) {

                json = jQuery.parseJSON(result);
                if (json.data.status) {
                    parent.attr('data-status', json.data.status);
                }
                if (json.data.percent >= 0) {
                    $('.progress-bar').css('width', json.data.percent + '%');
                    $('.progress-bar .sr-only .percent').html(json.data.percent);
                }
                if (json.data.comment) {
                    comment.text(json.data.comment);
                }
                if (json.data.error) {
                    parent.addClass('error');
                    setTimeout(function () {
                        parent.removeClass('error')
                    }, 1000);
                    errorText.text(json.data.error);
                } else {
                    errorText.text('');
                }
                parent.removeClass('process');
            }
        })
    });

    $('button[data-action="confimTask"]').click(function () {
        var elem = $(this);
        if (elem.hasClass('process')) {
            return;
        }
        var status = elem.attr('data-status');
        var taskid = elem.attr('data-id');
        var comment = $('textarea[data-task=' + taskid + ']').val();

        $('button[data-task=' + taskid + ']').addClass('process');
        $.ajax({
            url: '/admin/confirmtasks',
            type: 'post',
            data: {
                id: taskid,
                status: status,
                comment: comment
            },
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.data.status) {
                    $('tr[data-task=' + json.data.id + ']').remove();
                }
                elem.removeClass('process');
            }
        })
    });

    $('button[data-type="usercourses"]').click(function () {
        var elem = $(this);
        if (elem.hasClass('process')) {
            return;
        }
        var action = elem.attr('data-action');
        switch (action) {
            case 'delete':
                var user = elem.attr('data-user');
                var course = elem.attr('data-course');
                break;
            case 'add':
                var form = elem.closest('form');
                var user = form.find('select[name="user"]').val();
                var course = form.find('select[name="course"]').val();
                break;
        }
        elem.addClass('process');
        $.ajax({
            url: '/admin/usercourses',
            type: 'post',
            data: {
                action: action,
                user: user,
                course: course
            },
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.data.status) {
                    switch (json.data.status) {
                        case 'delete':
                            elem.closest('tr').fadeOut();
                            break;
                        case 'add':
                            var userInTable = '<tr><td>' + json.data.user.coursename + '</td><td>' + json.data.user.fullName + '</td><td>0</td><td><button class="btn btn-sm" data-type="usercourses" data-action="delete" data-user="' + json.data.user.userid + '" data-course="' + json.data.user.courseid + '">Удалить</button></td><tr>';
                            $('table tr:nth-child(1)').after(userInTable)
                            break
                    }
                }
                if (json.data.error) {
                    openModal('message', 'Ошибка', json.data.error);
                }
                elem.removeClass('process');
                $('.newusercourses').fadeOut();
                $('button[data-action=".newusercourses"]').fadeIn();
            }
        })
    });

    $('button[data-type="courseteacher"]').click(function () {
        var elem = $(this);
        if (elem.hasClass('process')) {
            return;
        }
        var action = elem.attr('data-action');
        switch (action) {
            case 'delete':
                var user = elem.attr('data-user');
                var course = elem.attr('data-course');
                break;
        }
        elem.addClass('process');
        $.ajax({
            url: '/admin/course-' + course + '/teachers',
            type: 'post',
            data: {
                action: action,
                user: user
            },
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.data.status) {
                    switch (json.data.status) {
                        case 'delete':
                            elem.closest('tr').fadeOut();
                            break;
                    }
                }
                if (json.data.error) {
                    openModal('message', 'Ошибка', json.data.error);
                }
                elem.removeClass('process');
            }
        })
    });

    $('button[data-type="coursestudent"]').click(function () {
        var elem = $(this);
        if (elem.hasClass('process')) {
            return;
        }
        var action = elem.attr('data-action');
        switch (action) {
            case 'delete':
                var user = elem.attr('data-user');
                var course = elem.attr('data-course');
                break;
        }
        elem.addClass('process');
        $.ajax({
            url: '/admin/course-' + course + '/students',
            type: 'post',
            data: {
                action: action,
                user: user
            },
            success: function (result) {
                json = jQuery.parseJSON(result);
                if (json.data.status) {
                    switch (json.data.status) {
                        case 'delete':
                            elem.closest('tr').fadeOut();
                            break;
                    }
                }
                if (json.data.error) {
                    openModal('message', 'Ошибка', json.data.error);
                }
                elem.removeClass('process');
            }
        })
    });

    $('button[data-type="show"]').click(function () {
        var elem = $(this);
        var show = elem.attr('data-action');
        elem.fadeOut();
        $(show).fadeIn();
    });

    $('button[data-type="payPromocode"]').click(function () {
        var elem = $(this);
        if (elem.hasClass('process')) {
            return;
        }
        elem.addClass('process');

        var promocode = $('input[name="promocode"]').val();
        var course = $('input[name="course"]').val();
        var price = $('input[name="price"]').attr('data-price');

        $.ajax({
            url: '/pay/' + course,
            type: 'post',
            data: {
                action: 'promocode',
                promocode: promocode,
                course: course
            },
            success: function (result) {
                json = jQuery.parseJSON(result);
                console.log(json);
                if (json.data.sale) {
                    var sale = json.data.sale;
                    var newprice;
                    if (sale.indexOf('%') > 0) {
                        var saleSum = price / 100 * parseFloat(sale);
                        newprice = Math.floor(price - saleSum);
                    } else {
                        newprice = price - sale;
                    }
                    $('input[name="price"]').val(newprice);
                    $('input[name="promocode"]').attr('readonly', '');
                }
                if (json.data.error) {
                    openModal('message', 'Ошибка', json.data.error);
                    $('input[name="price"]').val($('input[name="price"]').attr('data-price'));
                    $('input[name="promocode"]').val('');
                }
                elem.removeClass('process');
            }
        })
    });

    $('button[data-type="mobileMenu"]').click(function () {
        var elem = $(this);
        var action = elem.attr('data-action');
        if(action == 'open'){
            $('body').addClass('modalopen');
            $('.mobile-menu-wrapper').slideDown();
        }
        if(action == 'close'){
            $('body').removeClass('modalopen');
            $('.mobile-menu-wrapper').slideUp();
        }

    });

    $(".owl-carousel").owlCarousel({
        items: 4,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
    });

    videoHeight();
    
    $(window).resize(function () {
        videoHeight();
        minHeightContent();
        if ($('.lending-intro-content').length) {
            var headerHeight = $('.lending-intro .top').outerHeight();
            var baseHeight = $('.lending-intro-content').outerHeight();
            var windowHeight = $(window).height();
            var newPaddingBottom = Math.floor((windowHeight - headerHeight - baseHeight) / 2);
            $('.lending-intro .top').css('margin-bottom', newPaddingBottom);
        }
    });

});