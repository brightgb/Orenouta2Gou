var box_height;

$(function(){
	box_height = $('.js_acco').data('accordion-height');
	if(box_height === undefined) box_height = 40;
	$('.js_acco').each(function() {
		var $target     = $(this).find('.js_accoCont'); // コンテナ
		var	$button     = $(this).find('.js_accoBtn');  // ボタン

		// コメントがコンテナ高さに満たなければ処理を終了
		if ( $target.height() <= box_height ) return;

		$button.show();
		$target.addClass('closed');

		$button.bind('click', function(e) {
			e.preventDefault();
			$(this).toggleClass('open');

			if ( $target.attr('id') === 'active' ) {
				$target.removeAttr('id').addClass('closed');
				$(this).find('a').text('続きを読む');
			} else {
				$target.attr('id', 'active').removeClass('closed');
				$(this).find('a').text('閉じる');
			}
		});
	});
});
