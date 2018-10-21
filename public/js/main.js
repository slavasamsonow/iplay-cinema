// v.0.7.0
$(document).ready(function () {
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
			userController.mouseenter(function(){
				clearTimeout(closeUsercontroller);
			})
		})
	})

	// Левое меню
	$('.left-menu .parent span').click(function(){
		$(this).parent().children('ul').slideToggle();
	})

	var thisPage = document.location.pathname;
	$('a[href="'+thisPage+'"]').addClass('thisPage');
	$('a[href="'+thisPage+'"]').removeAttr('href');
	$('.left-menu .thisPage').parents('ul').slideDown();

	// Обработка форм
	$('input').focusin(function () {
		$(this).parent().addClass('active');
	});
	$('input').focusout(function () {
		if ($(this).val().length <= 0) {
			$(this).parent().removeClass('active');
		}
	});
	// Маска для телефона
	$("input[type=tel]").mask("+7 (999) 999-99-99");
	$("input[name=datetime]").mask('99.99.9999 99:99:99');

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
		$('.modal').hide();
		$('.modal.' + type + ' .modal-header').html(header);
		$('.modal.' + type + ' .modal-body').html(body);
		$('body').addClass('modalopen');
		$('.modal.' + type).show();
		$('#overlay').show();
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

	$(".coursePage button[data-modal='video']").click(function(){
		var videoName = $(this).data('videoname');
		$('.modal.video .modal-header').html(videoName);
		var video = $(this).data('video');
		$('.modal.video .modal-body').html(video);
	})

	// Для блока интро
	var headerHeight = $('.navbar').css('height');
	var footerHeight = $('footer').css('height');
	//$('.content .intro').css('margin-bottom', '-' + footerHeight);
	$('.content .intro').css('padding-top', headerHeight);

	// Минимальная высота сайта
	if (!$('.content.intro').length) {
		$('.wrapper').css('min-height', 'calc(100vh - ' + headerHeight + ' - ' + footerHeight + ')');
		$('footer').removeClass('load');
	}


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


	// Взаимодействие с заданием курса
	$('.tasks.course .task.active').click(function () {
		var elem = $(this);
		if (elem.hasClass('process')) {
			return;
		}
		var taskId = Number(elem.attr('data-id'));

		elem.addClass('process');
		elem.children('p').hide();
		$.ajax({
			url: '/study/checkTask',
			type: 'post',
			data: 'task=' + taskId,
			success: function (result) {
				json = jQuery.parseJSON(result);
				if (json.data.status) {
					elem.attr('data-status', json.data.status);
				}
				if (json.data.percent >= 0) {
					$('.progress-bar').css('width', json.data.percent + '%');
					$('.progress-bar .sr-only .percent').html(json.data.percent);
				}
				if (json.data.error) {
					elem.addClass('error');
					setTimeout(function () {
						elem.removeClass('error')
					}, 1000);
					$('span.error').remove();
					openModal('message', 'Ошибка', json.data.error)
				}
				elem.removeClass('process');
			}
		})
	})

	$('button[data-action="confimTask"]').click(function () {
		var elem = $(this);
		if (elem.hasClass('process')) {
			return;
		}
		var status = elem.attr('data-status');
		var taskid = elem.attr('data-id');
		var description = $('textarea[data-task=' + taskid + ']').val();

		$('button[data-task=' + taskid + ']').addClass('process');
		$.ajax({
			url: '/admin/confirmtasks',
			type: 'post',
			data: 'id=' + taskid + '&status=' + status + '&description=' + description,
			success: function (result) {
				json = jQuery.parseJSON(result);
				console.log(json);
				if (json.data.status) {
					$('tr[data-task=' + json.data.id + ']').remove();
				}
				elem.removeClass('process');
			}
		})
	})

	$(".owl-carousel").owlCarousel({
		items: 4,
		margin: 20,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
	});

});