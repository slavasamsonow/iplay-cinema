$(document).ready(function() {
    // Обработка форм
    $('input').focusin(function(){
		$(this).parent().addClass('active');
	});
	$('input').focusout(function(){
		if($(this).val().length <= 0){
			$(this).parent().removeClass('active');
		}
    });
    // Маска для телефона
    $("input[type=tel]").mask("+7 (999) 999-99-99");

	$('form').submit(function(event) {
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
			success: function(result) {
				json = jQuery.parseJSON(result);
				if (json.url) {
					window.location.href = '/' + json.url;
				}else if(json.urlo){
					window.location.href = json.urlo;
				}else if(json.modal == 'modalmessage') {
					$('.modal').hide();
					$('.modal.message .modal-header').html(json.modalheader);
					$('.modal.message .modal-body').html(json.modalbody);
					$('body').addClass('modalopen');
					$('.modal.message').show();
					$('.overlay').show();
				}
			},
		});
    });

    // Модальные окна
    $(".overlay").click(function(){
		$(".modal").hide();
		$(".overlay").hide();
		$("body").removeClass('modalopen');
	})
	$(".modal .close").click(function(){
		$(this).parent().hide();
		$(".overlay").hide();
		$("body").removeClass('modalopen');
	})

    // Высота окна
    var headerHeight = $('.navbar').css('height');
	var footerHeight = $('footer').css('height');
    $('.wrapper').css('min-height', 'calc(100vh - '+ headerHeight +' - '+ footerHeight +')');
});