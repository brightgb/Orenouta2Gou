@extends('layout.common')

@include('layout.song.header')

@section('content')
    @if ($errors->has('all_space'))
        <span style="color: red; font-size: small;">
            <strong>{{ $errors->first('all_space') }}</strong>
        </span><br>
    @elseif ($errors->has('new_pw'))
        <span style="color: red; font-size: small;">
            <strong>{{ $errors->first('new_pw') }}</strong>
        </span><br>
    @endif
<div class="profile_area">
    <div class="nickname">
        <span style="float: left;">&nbsp; ニックネーム</span>
        <br>
        <span style="float: right; word-break: break-all;">{{ $member->nickname }} &nbsp;</span>
        <br>
        <span style="float: left;">&nbsp; ログインID</span>
        <br>
        <span style="float: right; word-break: break-all;">{{ $member->userid }} &nbsp;</span>
    </div>
    <div class="password">
        <div style="margin-bottom: 50px;">
            <span style="float: left;">&nbsp; パスワード</span>
            <span style="float: right;">
                <button class="pw_change" id="modal-open">変 更</button> &nbsp;
            </span>
        </div>
        <span style="clear: both; float: right; word-break: break-all;">
            {{ $member->pw }} &nbsp;
        </span>
        {{-- モーダル --}}
        <div id="modal-content">
            <form method="post" onsubmit="return check()" action="">
                <p style="font-size: small;">パスワード（半角英数字4～8文字）</p>
                {{ csrf_field() }}
                <input type="text" maxlength="8" name="new_pw" value="{{ old('new_pw', $member->pw) }}" style="width: 90%;">
                <button style="margin-left: 10%; cursor: pointer; float: left; border-radius: 10px;" >
                    決定
                </button>
            </form>
            <button id="modal-close" style="margin-right: 10%; cursor: pointer; float: right; border-radius: 10px;">
                キャンセル
            </button>
        </div>
    </div>
    <div class="singer_rank">
        <span style="float: left;">&nbsp; 投稿曲数</span>
        <br>
        <span style="float: right; word-break: break-all;">
            {{ $member->sing_song_cnt }} &nbsp;
        </span>
        <br>
        <span style="float: left;">&nbsp; 獲得アドバイス数</span>
        <br>
        <span style="float: right; word-break: break-all;">
            {{ $member->get_advice_cnt }} &nbsp;
        </span>
        <br>
        <span style="float: left;">&nbsp; 獲得お気に入り登録数</span>
        <br>
        <span style="float: right; word-break: break-all;">
            {{ $member->get_favorite_cnt }} &nbsp;
        </span>
        <br>
        <!-- 歌い手ランク -->
        @if ($member->singer_rank == config('constSong.singer_rank_key.gold'))
            <div class="rank_gold">
                {{ config('constSong.singer_rank_label.2') }}
            </div>
        @elseif ($member->singer_rank == config('constSong.singer_rank_key.silver'))
            <div class="rank_silver">
                {{ config('constSong.singer_rank_label.1') }}
            </div>
        @else
            {{-- 通常会員は表示なし --}}
        @endif
    </div>
    <div class="advicer_rank">
        <span style="float: left;">&nbsp; アドバイス数</span>
        <br>
        <span style="float: right; word-break: break-all;">
            {{ $member->all_advice_cnt }} &nbsp;
        </span>
        <br>
        <span style="float: left;">&nbsp; 役に立ったと認定された数</span>
        <br>
        <span style="float: right; word-break: break-all;">
            {{ $member->get_nice_cnt }} &nbsp;
        </span>
        <br>
        <!-- アドバイザーランク -->
        @if ($member->advicer_rank == config('constSong.advicer_rank_key.gold'))
            <div class="rank_gold">
                {{ config('constSong.advicer_rank_label.2') }}
            </div>
        @elseif ($member->advicer_rank == config('constSong.advicer_rank_key.silver'))
            <div class="rank_silver">
                {{ config('constSong.advicer_rank_label.1') }}
            </div>
        @else
            {{-- 通常会員は表示なし --}}
        @endif
    </div>
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    .profile_area {
        width: 90vw;
        margin-left: 2.5vw;
        margin-bottom: 100px;
        border: 2px solid black;
        border-radius: 10px;
    }
    .nickname {
        width: 100%;
        padding: 15px 0;
        overflow: auto;
        background-color: white;
        border-bottom: 2px solid black;
        border-radius: 10px 10px 0 0;
    }
    .password, .singer_rank {
        width: 100%;
        padding: 15px 0;
        overflow: auto;
        background-color: white;
        border-bottom: 2px solid black;
    }
    .advicer_rank {
        width: 100%;
        padding: 15px 0;
        overflow: auto;
        background-color: white;
        border-radius: 0 0 10px 10px;
    }
    .pw_change {
        background-color: #222222;
        font-weight: bold;
        color: white;
        border: 1px solid gray;
        padding: 5px 15px;
        cursor: pointer;
    }
    .rank_gold {
        animation: color-change2 2s linear infinite;
        font-weight: bold;
        font-size: x-large;
        margin-top: 10px;
        margin-bottom: -10px;
    }
    @keyframes color-change2 {
      0%, 100% {
        color: #FFD700;
      }
      25% {
        color: #FFA500;
      }
      50% {
        color: #FF8C00;
      }
      75% {
        color: orange;
      }
    }
    .rank_silver {
        animation: color-change1 2s linear infinite;
        font-weight: bold;
        font-size: x-large;
        margin-top: 10px;
        margin-bottom: -10px;
    }
    @keyframes color-change1 {
      0%, 100% {
        color: #666666;
      }
      25% {
        color: #555555;
      }
      50% {
        color: #444444;
      }
      75% {
        color: gray;
      }
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
</style>

<script>
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
</script>
@endsection