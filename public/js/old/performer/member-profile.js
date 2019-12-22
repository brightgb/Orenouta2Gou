//お気に入り・ブロック
$(function() {
    var memberId     = $('#data').data('member-id');
    var favoriteFlag = $('#data').data('favorite-flag');
    var blockFlag    = $('#data').data('block-flag');

    // お気に入り 登録・解除 ボタンの表示切替
    if (favoriteFlag) {
        $('.fav-on').hide();
        $('.fav-off').show();
        $('.jealousy').show();
    } else {
        $('.fav-on').show();
        $('.fav-off').hide();
        $('.jealousy').hide();
    }
    // ブロック 登録・解除 ボタンの表示切替
    if (blockFlag) {
        $('.block-on').hide();
        $('.block-off').show();
    } else {
        $('.block-on').show();
        $('.block-off').hide();
    }

    // メモ
    $('.memo-open').click(function(event) {
        openModal('modal-memo');
    });
    // メモ保存
    $('.memo-save').click(function(event) {
        $.ajax({
            type: "POST",
            url:  "/performer/api/memo/update",
            data: {
                member_id : memberId,
                memo      : $('.modal-memo textarea').val().replace(/\n/g,'\r\n')
            },
        })
        .done(function(ret) {
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

    // 文字数制限とカウント
    $(function(){
        $('textarea').on('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().replace(/[\n\s ]/g, "").length;
        var v = $(this).val();
        $('.count').html(thisValueLength);
            if (thisValueLength > 500) {
                alert("メモが長すぎます。");
                $(this).val(v.substr(0,500));
            }
        });
    });

    // 履歴
    $('.hist-open').click(function(event) {
        openModal('modal-hist');
    });

    //追加メニュー
    $('.select-open').click(function(event) {
        openModal('modal-select');
    });

    // お気に入り 登録
    $('.fav-on').click(function(){
        $.ajax({
            type: "POST",
            url: "/performer/api/fav/on",
            data: { member_id : memberId },
        })
        .done(function(ret) {
            $('.fav-on').hide();
            $('.fav-off').show();
            $('.jealousy').show();
            closeModal();
            openModal('modal-fav-on');
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });
    // お気に入り 解除
    $('.fav-off').click(function() {
        if (!confirm('本当にお気に入り解除しますか？')) return;

        $.ajax({
            type: "POST",
            url: "/performer/api/fav/off",
            data: { member_id : memberId },
        })
        .done(function(ret) {
            $('.fav-on').show();
            $('.fav-off').hide();
            $('.jealousy').hide();
            closeModal();
            openModal('modal-fav-off');
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });

    // ブロック 登録
    $('.block-on').click(function() {
        if (!confirm('本当にブロックしますか？')) return;

        $.ajax({
            type: "POST",
            url: "/performer/api/block/on",
            data: { member_id : memberId },
        })
        .done(function(ret) {
            $('.block-on').hide();
            $('.block-off').show();
            closeModal();
            openModal('modal-block-on');
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });
    // ブロック 解除
    $('.block-off').click(function() {
        if (!confirm('本当にブロックを解除しますか？')) return;

        $.ajax({
            type: "POST",
            url: "/performer/api/block/off",
            data: { member_id : memberId },
        })
        .done(function(ret) {
            $('.block-on').show();
            $('.block-off').hide();
            closeModal();
            openModal('modal-block-off');
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
    });
});