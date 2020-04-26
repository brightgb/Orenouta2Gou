@extends('layout.common')

@include('layout.song.header')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- 固定部分 --}}
<div style="margin-top: -110px; width: 100vw; position: fixed; z-index: 9998; background-color: silver;">
    <div style="height: 120px; margin: 15px 5% 0 1%; padding-bottom: 5px; text-align: center;">
        <iframe id="ytplayer" type="text/html" width="auto" height="100%"
                src="https://www.youtube.com/embed/{{ $song->file_name }}?color=white&fs=0&rel=0&origin=http://orenouta2gou.s1009.xrea.com" frameborder="0">
        </iframe>
    </div>
    <span class="advice_line">
        @if (!$fav_flg) {{-- お気に入り未登録 --}}
            <img src="/storage/icon/fav_to_on.png" style="cursor: pointer; position: relative; top: -1px; height: 25px;" id="fav_to_on">
        @else
            <img src="/storage/icon/fav_to_off.png" style="cursor: pointer; position: relative; top: -1px; height: 25px;" id="fav_to_off">
        @endif
        &nbsp;＜ コメント欄 ＞&nbsp;
        @if ($no_advice_flg) {{-- 未アドバイス --}}
            <a id="modal-open" style="cursor: pointer;">
                <img src="/storage/icon/comment.png" style="height: 30px;">
            </a>
        @else
            <img src="/storage/icon/other_comment.png" style="height: 30px;">
        @endif
    </span>
</div>

{{-- スクロール部分 --}}
@if (count($advice_list) == 0)
    <div style="padding-top: 100px; margin: 150px 0 70px 0; width: 100%; text-align: center; clear: both;">
        @if ($errors->has('all_space'))
            <div class="error_message" style="margin-bottom: 20px;">
                {{ $errors->first('all_space') }}
            </div>
        @elseif ($errors->has('advice'))
            <div class="error_message" style="margin-bottom: 20px;">
                {{ $errors->first('advice') }}
            </div>
        @endif
        <div style="padding: 10px; margin: 0 1% 50px 2%; width: 90%; border: 1px solid #333333; border-radius: 10px; background-color: silver; display: inline-block; text-align: center;">
            まだ何も書き込まれていません
        </div>
    </div>
@else
    <div style="padding-top: 70px; margin: 150px 0 100px 0; width: 100%; text-align: center; clear: both;">
        @if ($errors->has('all_space'))
            <div class="error_message" style="margin-top: 20px;">
                    {{ $errors->first('all_space') }}
            </div>
        @elseif ($errors->has('advice'))
            <div class="error_message" style="margin-top: 20px;">
                {{ $errors->first('advice') }}
            </div>
        @endif
        <div id="list" style="width: 100%; margin-bottom: 30px; height: auto;">
        @foreach ($advice_list as $key => $value)
            <div class="li" style="background-color: #FFFF99; border-radius: 10px; border: 1px solid #333333; padding: 5px 1%; margin: 20px 5%; display: flex;">
                <img src="/storage/icon/other_comment.png" style="height: 30px; margin: 5px;">
                <div style="width: 100%; margin-left: 1%; text-align: left;">
                    {!! $value['advice'] !!}
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endif

{{-- モーダル --}}
<div id="modal-content">
    <form method="post" onsubmit="return check()" action="/song/song_advice/post">
        <p style="font-size: small;">最大３００文字<br>※ アドバイスは１曲につき、１回までです</p>
        {{ csrf_field() }}
        <input type="hidden" name="song_id" value="{{ $song->id }}">
        <textarea name="advice" maxlength="300" style="width: 100%; height: 100px; margin: -0.5em 0 0.5em 0;" required>{{ old('advice') }}</textarea><br>
        <button style="cursor: pointer; float: left; border-radius: 10px;" >
            決定
        </button>
    </form>
    <button id="modal-close" style="cursor: pointer; float: right; border-radius: 10px;">
        キャンセル
    </button>
</div>

<style>
    body {
        box-sizing: border-box;
    }
    .advice_line {
        display: flex;
        align-items: center;
        margin: 1% 4% 0 1%;
    }
    .advice_line:before, .advice_line:after {
        content: "";
        flex-grow: 1;
        height: 1px;
        background: black;
        margin: 1em;
    }
    .morelink{
        margin: 20px 85px;
        padding: 5px 20px;
        background: #ff9900;
        border:1px solid black;
        text-align: center;
    }
    .morelink:hover{
        cursor: pointer;
        border: 2px solid black;
        background: orange;
    }
    /* モーダル */
    #modal-content {
        width: 80%;
        top: 40%;
        padding: 10px 20px;
        border: 2px solid #aaa;
        background: #fff;
        position: fixed;
        display: none;
        z-index: 9998;
        text-align: center;
    }
    #modal-overlay {
        z-index: 9997;
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 120%;
        background-color: rgba(191, 191, 191, 0.75);
    }
    .error_message {
        color: red;
        font-weight: bold;
        font-size: small;
    }
</style>

<script>
    // １０個ずつコメント表示
    $(function() {
        //分割したい個数を入力
        var division = 10;
        //要素の数を数える
        var divlength = $('#list .li').length;
        if (divlength <= division) {
            return;
        }
        //分割数で割る
        dlsizePerResult = divlength / division;
        //分割数 刻みで後ろにmorelinkを追加する
        for (i=1; i<=dlsizePerResult; i++) {
            if (i >= dlsizePerResult) {
                $('#list .li').eq(division*i-1);
            } else {
                $('#list .li').eq(division*i-1)
                    .after('<div class="morelink link' + i +'">続きを表示</div>');
            }
        }
        //最初のli（分割数）と、morelinkを残して他を非表示
        $('#list .li,.morelink').hide();
        for (j=0; j<division; j++) {
            $('#list .li').eq(j).show();
        }
        $('.morelink.link1').show();
        //morelinkにクリック時の動作
        $('.morelink').click(function() {
            //何個目のmorelinkがクリックされたかをカウント
            index = $(this).index('.morelink');
            //(クリックされたindex +2) * 分割数 = 表示数
            for (k=0; k<(index+2)*division; k++) {
                $('#list .li').eq(k).fadeIn();
            }
            //一旦全てのmorelink削除
            $('.morelink').hide();
            //次のmorelink(index+1)を表示
            $('.morelink').eq(index+1).show();
        });
    });

    // モーダル
    var sX_syncerModal = 0;
    var sY_syncerModal = 0;
    $(function() {
        //モーダルウィンドウを出現させるクリックイベント
        $("#modal-open").click(function() {
            //キーボード操作などにより、オーバーレイが多重起動するのを防止する
            $(this).blur();    //ボタンからフォーカスを外す
            if($("#modal-overlay")[0]) return false;       //新しくモーダルウィンドウを起動しない
            //スクロール位置を記録する
            var dElm = document.documentElement , dBody = document.body;
            sX_syncerModal = dElm.scrollLeft || dBody.scrollLeft;   //現在位置のX座標
            sY_syncerModal = dElm.scrollTop || dBody.scrollTop;     //現在位置のY座標
            //オーバーレイを出現させる
            $("body").append('<div id="modal-overlay"></div>');
            $("#modal-overlay").fadeIn("slow");
            //コンテンツをセンタリングする
            centeringModalSyncer();
            //コンテンツをフェードインする
            $("#modal-content").fadeIn("slow");
            //[#modal-close]をクリックしたら…
            $("#modal-close").unbind().click(function() {
                //スクロール位置を戻す
                window.scrollTo(sX_syncerModal, sY_syncerModal);
                //[#modal-content]と[#modal-overlay]をフェードアウトした後に…
                $("#modal-content,#modal-overlay").fadeOut("slow", function() {
                    //[#modal-overlay]を削除する
                    $('#modal-overlay').remove();
                });
            });
        });
        //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
        $(window).resize(centeringModalSyncer);
        //センタリングを実行する関数
        function centeringModalSyncer() {
            //画面(ウィンドウ)の幅、高さを取得
            var w = $(window).width();
            var h = $(window).height();
            //コンテンツ(#modal-content)の幅、高さを取得
            var cw = $("#modal-content").outerWidth();
            var ch = $("#modal-content").outerHeight();
            //センタリングを実行する
            $("#modal-content").css({"left": ((w - cw)/2) + "px", "top": ((h - ch)/2) + "px"})
        }
    });
    // フォーム送信
    function check() {
        return confirm("この内容でよろしいですか？");
    }

    // お気に入り登録切り替え
    var member_id = "<?php echo $song->member_id; ?>";
    $('#fav_to_on').click(function() {
        if (!confirm('お気に入りに登録しますか？')) return;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/song/api/fav_switch",
                data: {member_id : member_id,
                       fav_to_on : 1,
                       fav_to_off : 0},
            })
            .done(function(ret) {
                // data-val を不正に打ち換えて送信
                if (ret.status == 'NG') {
                    alert('通信に失敗しました。');  // 管理側の強制削除と同時だった場合を考慮
                    location.reload();
                }
                // 成功
                else {
                    alert('登録しました。')
                    location.reload();
                }
            })
            .fail(function(err) {
                alert('通信に失敗しました。');
            });
    });
    $('#fav_to_off').click(function() {
        if (!confirm('お気に入り解除しますか？')) return;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/song/api/fav_switch",
                data: {member_id : member_id,
                       fav_to_on : 0,
                       fav_to_off : 1},
            })
            .done(function(ret) {
                // data-val を不正に打ち換えて送信
                if (ret.status == 'NG') {
                    alert('通信に失敗しました。');  // 管理側の強制削除と同時だった場合を考慮
                    location.reload();
                }
                // 成功
                else {
                    alert('解除しました。')
                    location.reload();
                }
            })
            .fail(function(err) {
                alert('通信に失敗しました。');
            });
    });
</script>
@endsection