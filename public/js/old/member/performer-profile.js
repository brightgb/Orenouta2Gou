/* jshint -W100 */
$(document).ready(function() {
    var $a_item = $("#title a");
    if ($a_item.length == 2) {
        $("#title a:first-of-type").css({
            "right": 50 + "px"
        });
        $("#title").css({
            "padding-right": 89 + "px"
        });
    } else if ($a_item.length == 1) {
        $("#title").css({
            "padding-right": 47 + "px"
        });
    }


    //NO IMAGEなら拡大できない
    if ($('.prof_img a').attr('href') == "image/A001/photo_men1.gif") {
        $('.prof_img a').removeAttr('data-lightbox');
        $('.prof_img a').removeAttr('href');
        console.log('ddtime');
    }
});


// プロフイメージ スライダー
$(function() {
    $('#slider').slick({
        lazyLoad: 'ondemand',
        asNavFor: '#slider-nav',
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        // fade: true,
        waitForAnimate: false,
        infinite: false,
    });
    $('#slider-nav').slick({
        lazyLoad: 'ondemand',
        asNavFor: '#slider',
        swipeToSlide: true,
        slidesToShow: 4,
        arrows: true,
        accessibility: true,
        focusOnSelect: true,
        touchMove: true,
        swipe: false,
        waitForAnimate: false,
        centerMode: false,
        infinite: false,
    });

    $(window).on('load resize', function() {
        if ($('#slider').length == 0) {
            return;
        }

        setTimeout(function() {
            $('img[name=slick_block1]').off().remove();

            var $slider = $('#slider');
            var position = $slider.offset();
            var height = $slider.height();
            var width = $slider.width();
            var $img = $('<img />');

            $img.attr({
                width: width,
                height: height,
                name: "slick_block1"
            }).css({
                top: position.top,
                left: position.left,
                position: 'absolute',
                zIndex: '999' //1000だとメニューとかぶる
            }).on('touchstart mousedown touchmove mousemove touchend mouseup touchcancel mouseleave', function(evt) {
                if (evt.type == 'mousedown' || evt.type == 'mousemove' || evt.type == 'mouseup' || evt.type == 'mouseleave') { //touch系のスクロール許可
                    evt.preventDefault();
                }

                var clone_evt = $.Event(evt.type, {
                    'keyCode': evt.keyCode,
                    'originalEvent': evt.originalEvent,
                    'clientX': evt.clientX,
                    'clientY': evt.clientY
                });

                $('#slider .slick-slide.slick-current.slick-active img.wd100[name=noblock]').trigger(clone_evt);
            }).appendTo('body');

            $('img[name=slick_block2]').off().remove();

            $('#slider-nav img.wd100[name=noblock]').each(function(index) {
                var self = this;
                var position = $(this).offset();
                var height = $(this).height();
                var width = $(this).width();
                var $img = $('<img />');

                $img.attr({
                    width: width,
                    height: height,
                    name: "slick_block2"
                }).css({
                    top: position.top,
                    left: position.left,
                    position: 'absolute',
                    zIndex: '11'
                }).on('click', function(evt) {
                    $(self).trigger('click');
                }).appendTo('body');
            });

        }, 300);
    });
});

/////お気に入り・拒否・待機通知
var jqxhr;
$(function() {
	var performer_id = $('#data').data('performer-id');
	var fav_flag 	 = $('#data').data('favorite-flag');
    var block_flag   = $('#data').data('block-flag');
    var notify_flag  = $('#data').data('notify-flag');

    //メモ
    $('.memo-open').click(function(event) {
        openModal('modal-memo');
    });

    //贈る
    $('.prsnt-open').click(function(event) {
        openModal('modal-prsnt');
    });

    //履歴
    $('.hist-open').click(function(event) {
        openModal('modal-hist');
    });

    //追加
    $('.select-open').click(function(event) {
        openModal('modal-select');
    });

    var switchIcons = function() {
        if (typeof fav_flag != "undefined") {

            if (fav_flag) { //お気に入り登録されている
                $('.fav_switch').text('お気に入りを解除する');
                $('.fav_switch').removeClass('favon');
                $('.fav_switch').addClass('favoff');
            } else {
                $('.fav_switch').text('お気に入りに追加する');
                $('.fav_switch').removeClass('favoff');
                $('.fav_switch').addClass('favon');
            }

            if (block_flag) { //拒否している
                $('.ref_switch').text('ブロックを解除');
                $('.ref_switch').addClass('refoff');
            } else {
                $('.ref_switch').text('ブロックする');
                $('.ref_switch').addClass('refon');
            }

            if (fav_flag) { //男性
                //waiting_notfy
                $('.wan_switch').css('display', 'block');
                if (notify_flag) { //待機通知しない
                    $('.wan_switch').text('待機通知を受け取る');
                    $('.wan_switch').addClass('wanon');
                } else {
                    $('.wan_switch').text('待機通知を受け取らない');
                    $('.wan_switch').addClass('wanoff');
                }
            } else {
                $('.wan_switch').css('display', 'none');
            }

        } else {

        }
    };
    switchIcons();

    //お気に入り追加
    $('.favon').live("click", function() {
        jqxhr = $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/favorite/switch',
            data: { _token : $('meta[name="csrf-token"]').attr('content'), performer_id	: performer_id },
        })
            .done(function(ret) {
                if (ret.indexOf('お気に入りリストに追加しました') != -1) {
                    fav_flag = 1;
                    switchIcons();
                    closeModal();
                    openModal('modal-fav-on');
                } else {
                    alert('通信に失敗しました。');
                }
            })
            .fail(function() {
                alert('通信に失敗しました。');
            });
        return false;
    });

    //お気に入り解除
    $('.favoff').live("click", function() {
        if (!confirm('本当にお気に入り解除しますか？')) { return; }
        jqxhr = $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/favorite/switch',
            data: {_token : $('meta[name="csrf-token"]').attr('content'), performer_id	: performer_id },
        })
        .done(function(ret) {
            fav_flag = 0;
            switchIcons();
            closeModal();
            openModal('modal-fav-off');
        })
        .fail(function() {
            alert('通信に失敗しました。');
        });
        return false;
    });

    //拒否設定
    $('.refon').click(function() {
        if (!confirm('本当にブロックしますか？')) {
            return false;
        }

        jqxhr = $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/block/switch',
            data: {_token : $('meta[name="csrf-token"]').attr('content'), performerId : performer_id},
        })
            .done(function(ret) {
                if (ret.indexOf('ブロックリストに追加しました') != -1) {
                    block_flag = 1;
                    switchIcons();
                    closeModal();
                } else {
                    alert('通信に失敗しました。');
                }
            })
            .fail(function() {
                alert('通信に失敗しました。');
            });
        location.href = performer_id+"/blocked";

        return false;
    });


    //拒否解除
    $('.refoff').click(function() {
        if (!confirm('本当にブロックを解除しますか？')) {
            return false;
        }
        jqxhr = $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/block/switch',
            data: {_token : $('meta[name="csrf-token"]').attr('content'), performerId : performer_id },
        })
            .done(function(ret) {
                block_flag = 0;
                switchIcons();
                closeModal();
                openModal('modal-kyohi');
            })
            .fail(function() {
                alert('通信に失敗しました。');
            });
        return false;
    });


    //待機開始通知受け取らない
    $('.wanon').live("click", function() {
        jqxhr = $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/wan/switch',
            data: { _token : $('meta[name="csrf-token"]').attr('content'), performer_id	: performer_id },
        })
            .done(function(ret) {
                if (ret) {
                    notify_flag = 0;
                    alert('待機通知設定をオンにしました。');
                    switchIcons();
                    closeModal();
                    location.reload();
                } else {
                    alert('通信に失敗しました。');
                }
            })
            .fail(function() {
                alert('通信に失敗しました。');
            });
        return false;
    });

    //待機開始通知を受け取る
    $('.wanoff').live("click", function() {
        jqxhr = $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/member/api/wan/switch',
            data: {_token : $('meta[name="csrf-token"]').attr('content'), performer_id	: performer_id },
        })
            .done(function(ret) {
                notify_flag = 1;
                alert('待機通知設定をオフにしました。');
                switchIcons();
                closeModal();
                location.reload();
            })
            .fail(function() {
                alert('通信に失敗しました。');
            });
        return false;
    });


    //待機通知設定
    // $('.wanon').click(function() {
    //     jqxhr = $.ajax({
    //             type: "GET",
    //             url: "Profile.aspx",
    //             data: {
    //                 notrx: 0
    //             },
    //         })
    //         .done(function(ret) {
    //             alert('待機通知設定をオンにしました。');
    //             location.href = location.pathname + location.search.replace(/&direct=1/, '') + "&direct=1";
    //         })
    //         .fail(function(jqXHR, textStatus, errorThrown) {
    //             alert('通信に失敗しました。6');
    //             alert("XMLHttpRequest : " + jqXHR.status);
    //             alert("textStatus : " + textStatus);
    //             alert("errorThrown : " + errorThrown);
    //         });
    //     return false;
    // });
    //
    // //待機通知解除
    // $('.wanoff').click(function() {
    //     jqxhr = $.ajax({
    //             type: "GET",
    //             url: "Profile.aspx",
    //             data: {
    //                 notrx: 1
    //             },
    //         })
    //         .done(function(ret) {
    //             alert('待機通知設定をオフにしました。');
    //             location.href = location.pathname + location.search.replace(/&direct=1/, '') + "&direct=1";
    //         })
    //         .fail(function(jqXHR, textStatus, errorThrown) {
    //             alert('通信に失敗しました。');
    //             alert("XMLHttpRequest : " + jqXHR.status);
    //             alert("textStatus : " + textStatus);
    //             alert("errorThrown : " + errorThrown);
    //         });
    //     return false;
    // });

    //メモ保存
    $('.memo-save').click(function(event) {
        jqxhr = $.ajax({
            type: 'POST',
            url: '/member/api/memo/update',
            data: {
                isAjax		: 1,
                // loginId		: LoginId,
                userRecNo	: 1,
                memo		: $('.modal-memo textarea').val(),
                performer_id	: performer_id
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

    //プレゼント
    $('.send-present').click(function () {
        var present    = $('.modal-prsnt [name=point] option:selected').val().split(':');
        var point      = Number(present[0]);
        var chargeType = present[1];

        if(!confirm(chargeType + "(" + point + "pt)を送ります。よろしいですか？")) return;

        jqxhr = $.ajax({
            type : "POST",
            url  : "/member/api/present/send",
            data : {
                isAjax        : 1,
                performer_id  : performer_id,
                point         : point,
                chargetype    : chargeType
            },
        })
        .done(function (ret) {
            // 現在のmodalを閉じる
            $('.modal-prsnt').hide();
            $('#modal-overlay').remove();

            $('.modal-present-sent div').hide();
            $('.modal-present-sent .present-' + point).show();
            openModal('modal-present-sent');
        })
        .fail(function () {
            alert('通信に失敗しました。');
        });
    });
});