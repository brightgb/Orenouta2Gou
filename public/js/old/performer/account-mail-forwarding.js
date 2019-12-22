$(function () {
	// 設定の更新
	$('input, select').on('change', function() {
		var data = {[$(this).attr('name')] : $(this).is(':checkbox') ? +$(this).prop('checked') : $(this).val()};

		$.ajax({
			url:$('#data').data('api'),
			type:'POST',
			data: data
		}).done(function(result){
			// console.log(result);
			closeMenu();
		}).fail(function(error){
			alert('データの更新に失敗しました。\n時間を置いてもう一度お試しください。');
			location.reload();
		});
	});

	// 受信設定 スライドメニュー
	// スライドメニューの開閉
	var openMenu = function(target){
		$(target).addClass('open').animate(
			{'width' : $(document.body).width() - 60},
			{'complete' : function() { $('<div>', {id: 'dummy'}).insertAfter($('#menuList')); }}
		);
		window.scrollTo(0, 0);
	};

	var closeMenu = function(){
		$('#dummy').remove();
		$('.selectarea.open').animate({'width' : 0}).removeClass('open');
		window.scrollTo(0, 0);
	}

	$('.selectbox').on('click', function() {
		openMenu($(this).siblings('.selectarea'));
	});

	$('.backselect').on('click', function() {
		closeMenu();
	});

	// 選択中項目の表示切り替え
	var switchSelected = function(target){
		if ($(target).length == 0 || !$(target).is('.selectarea ul li')) return;
		// チェックマークの表示切替
		$(target).addClass('selected').append($('<span>'));
		$(target).siblings('li').each(function(){
			$(this).removeClass('selected').children('span').remove();
		});
		// 短縮形表示の変更
		$(target).parents('.selectarea').siblings('.selectbox').children('.shorthand').text($(target).data('shorthand'));
	};

	// ページロード時の設定を表示に反映
	$('.selectarea').each(function(){
		var currentValue = $(this).children('input').val();
		var selected = $(this).find(`li[data-value="${currentValue}"]`);
		switchSelected(selected);
	});

	// 選択項目を更新
	$('.selectarea ul li').on('click', function(){
		if ($(this).hasClass('selected')) return; // 選択中の項目をクリックしたときはアクション無し

		$(this).parents('.selectarea').children('input').val($(this).data('value')).trigger('change');
		switchSelected($(this));
	});
});
