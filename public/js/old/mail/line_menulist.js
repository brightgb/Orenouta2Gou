$(function() {
	var apiURL       = $('#data').data('api-url');
	var memberId     = $('#data').data('member-id');
	var performerId  = $('#data').data('performer-id');
	var favFlag 	 = $('#data').data('favorite-flag');
	var menuOpenFlag = false;

	if ($(".message").length > 0) {
		// ロード時 最新受信メールまでスクロール
		$(window).load(function() {
			$('html,body').animate({ scrollTop: $(".message:last").offset().top - 51 }, 1);// 51 = ヘッダーの高さ
		});
	}

	//ヘッダーメニューの開閉
	$('.menu_button').css('cursor', 'pointer').click(function() {
		if (!menuOpenFlag) {
			$('#menuList').slideDown(200, function() {
				$(".menu_button").addClass('active');
				menuOpenFlag = true;
			});
		} else {
			$('#menuList').slideUp(100, function() {
				$(".menu_button").removeClass('active');
				menuOpenFlag = false;
			});
		}
		window.scrollTo(0, 0);
	});

    //お気に入り
    var switchFavIcon = function(){
        if (favFlag) {
            //お気に入り登録されている
            $('.fav_switch').html('<span></span>登録済み');
            $('.fav_switch').removeClass('favon');
            $('.fav_switch').addClass('favoff');
        } else {
            //お気に入り登録されていない
            $('.fav_switch').html('<span></span>お気入り');
            $('.fav_switch').removeClass('favoff');
            $('.fav_switch').addClass('favon');
        }
    };
    switchFavIcon();
	//お気に入り追加
	$('.favon').live("click", function() {
		jqxhr = $.ajax({
			type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: apiURL + '/favorite/switch',
			data: {_token : $('meta[name="csrf-token"]').attr('content'), performer_id : performerId, member_id : memberId},
		})
		.done(function(ret) {
			openModal('modal-fav-on');
			favFlag = !favFlag;
			switchFavIcon();
		})
		.fail(function() {
			alert('通信に失敗しました。');
		});
	});
	//お気に入り解除
	$('.favoff').live("click", function() {
		if (!confirm('本当にお気に入り解除しますか？')) { return; }
		jqxhr = $.ajax({
			type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: apiURL + '/favorite/switch',
			data: {_token : $('meta[name="csrf-token"]').attr('content'), performer_id : performerId, member_id : memberId},
		})
		.done(function(ret) {
			openModal('modal-fav-off');
			favFlag = !favFlag;
            switchFavIcon();
		})
		.fail(function() {
			alert('通信に失敗しました。');
		});
	});
	//メモ
	//メモ編集
	$('.memo-open').click(function(event) {
		openModal('modal-memo');
	});
	//メモ保存
	$('.memo-save').click(function(event) {
		jqxhr = $.ajax({
			type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: apiURL + '/memo/update',
			data: {
				memo		: $('.modal-memo textarea').val(),
				performer_id	: performerId,
				member_id 	: memberId
			},
		})
		.done(function(ret) {
			console.log(ret);
			if (ret.status == 9) {
				alert('「'+ret.ng_word+'」の単語が不正です。');
			} else {
				closeModal();
				openModal('modal-memo-saved');	
			}
		})
		.fail(function() {
			alert('通信に失敗しました。');
		});
	});

	//男性プロフ
	$('.prof-open').click(function(event) {
		openModal('modal-prof');
    });
    //マナー返信
  	$('.modal-open').click(function (event) {
        openModal('modal-content');
		event.stopPropagation();
    });

});
