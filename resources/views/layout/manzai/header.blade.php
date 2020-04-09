@section('header')
<div class="top_menu">
    <div class="left">
        <span><a href="/"><img src="/storage/icon/home.png" class="top_icon"><br></a></span>
        <span class="top_text">TOP</span>
    </div>
    <div class="right">
        <span><a href="/info"><img src="/storage/icon/info.png" class="top_icon"><br></a></span>
        <span class="top_text">新着情報</span>
        <div class="hamburger" id="js-hamburger">
            <span class="hamburger__line hamburger__line--1"></span>
            <span class="hamburger__line hamburger__line--2"></span>
            <span class="hamburger__line hamburger__line--3"></span>
            <span class="menu_text">MENU</span>
        </div>
        <div class="black-bg" id="js-black-bg"></div>
    </div>

        {{-- メインメニュー --}}
        <nav class="global-nav">
            <ul class="global-nav__list">
                <li class="global-nav__item">
                    <a href="/about_site">
                        <img src="/storage/icon/about.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        俺の歌を育てろ とは？
                    </a>
                </li>
                <li class="global-nav__item">
                    <a href="/profile">
                        <img src="/storage/icon/profile.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        管理人プロフィール
                    </a>
                </li>
                <li class="global-nav__item">
                    <a href="/song_list">
                        <img src="/storage/icon/music.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        投稿した歌唱曲一覧
                    </a>
                </li>
                <li class="global-nav__item">
                    <a onclick="func1()">
                        <strong><span id="omake_kigou" class="omake1">＞</span></strong>
                        <span style="margin-left: 30px;">おまけメニュー（開発中）</span>
                    </a>
                </li>
                    {{-- サブメニュー --}}
                    <ul id="acordion" class="hide">
                        <li class="global-nav-sub__item">
                            <a href="/caster_board">
                                <img src="/storage/icon/board.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                キャスターボード
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/rubber_shot">
                                <img src="/storage/icon/rubber.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                輪ゴム飛ばし
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/dj_play">
                                <img src="/storage/icon/DJ.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                DJプレイ
                            </a>
                        </li>
                    </ul>
                <li class="global-nav__item" id="yohaku">
                    <a href="/request">
                        <img src="/storage/icon/request.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        お問い合わせ・要望
                    </a>
                </li>
            </ul>
        </nav>
</div>
@endsection