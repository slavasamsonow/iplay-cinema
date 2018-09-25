// V.1.1

$(document).ready(function () {
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

	$('form').submit(function (event) {
		if ($(this).hasClass('no_ajax')) {
			return;
		}
		var json;
		event.preventDefault();
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

	// Отступы у Прокручиваемого
	var headerHeight = $('.navbar').css('height');
	var footerHeight = $('footer').css('height');
	$('.wrapper').css('padding-top', headerHeight);
	$('.wrapper').css('padding-bottom', footerHeight);

	//Блок Интро включает в себя шупку и подвал
	$('.intro').css('margin-top', '-' + headerHeight);
	$('.intro').css('margin-bottom', '-' + footerHeight);
	/*$('.intro').css('padding-top', headerHeight);
	$('.intro').css('padding-bottom', footerHeight);
	*/


	if ($('#introVideo').length) {
		var introvideo = $("#introVideo")[0];
		var durationTrue = setInterval(function(){
			var duration = introvideo.duration;
			if(duration){
				clearInterval(durationTrue);
				startIntroVideo(introvideo);
			}
		}, 100)

		function startIntroVideo(introvideo){
			$('.intro .background .video-shape').addClass('end');
			introvideo.play();

			setTimeout(function () {
				$('.intro .background .video-shape').addClass('out');
				$('.intro .background .big-left-triangle').addClass('left');
			}, 3000)
		}

		/*$('.introplay').click(function () {
			if (introvideo.paused) {
				introvideo.play();
			} else {
				introvideo.pause();
			}
		})

		$('.introplay').click();*/
	}


	// Взаимодействие с заданием курса
	$('.tasks.course .task.active').click(function () {
		var elem = $(this);
		if (elem.hasClass('process')) {
			return;
		}
		var taskId = Number(elem.attr('data-id'));

		elem.addClass('process');
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


});