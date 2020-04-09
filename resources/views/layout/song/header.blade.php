@section('header')
<div class="top_menu">
    <div class="left">
        <span><a href="/song"><img src="/storage/icon/home.png" class="top_icon"><br></a></span>
        <span class="top_text">TOP</span>
    </div>
    <div class="right">
        <span><a href="/song/info"><img src="/storage/icon/info.png" class="top_icon"><br></a></span>
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
            @guest  {{-- 未ログイン --}}
                <li class="global-nav__item">
                    <a href="/song/about_site">
                        <img src="/storage/icon/about.png" height="20"
                             style="position: relative; top: 2px;">&nbsp;
                        俺の歌を育てろ とは？
                    </a>
                </li>
                <li class="global-nav__item">
                    <a href="/song/regist">
                        <img src="/storage/icon/regist.png" height="20"
                             style="position: relative; top: 2px;">&nbsp;
                        会員登録　<span class="free">無料</span>
                    </a>
                </li>
                <li class="global-nav__item">
                    <span class="login_span">
                        既にアカウントをお持ちの方<br><br>
                        <a href="/song/login" class="login_link"
                           style="border-bottom: 1px solid black; padding: 7px;">ログイン</a>
                    </span>
                </li>
            @endguest
            @auth  {{-- ログイン済み --}}
                <li class="global-nav__item">
                    <a href="/song/about_site">
                        <img src="/storage/icon/about.png" height="20"
                             style="position: relative; top: 2px;">&nbsp;
                        俺の歌を育てろ とは？
                    </a>
                </li>
                <li class="global-nav__item">
                    <a onclick="func1()">
                        <img src="/storage/icon/profile.png" height="20"
                             style="position: relative; top: 2px;">&nbsp;
                        <span style="margin-right: 20px;">マイメニュー</span>
                        <strong><span id="omake_kigou" class="omake1">＞</span></strong>
                    </a>
                </li>
                    {{-- マイメニュー --}}
                    <ul id="acordion" class="hide">
                        <li class="global-nav-sub__item">
                            <a href="/song/my_account">
                                <img src="/storage/icon/account.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                アカウント確認
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/song/account/my_song">
                                <img src="/storage/icon/music.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                自分の過去投稿曲
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/song/account/sing_song">
                                <img src="/storage/icon/song_post.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                歌唱曲を投稿する
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/song/my_favorite">
                                <img src="/storage/icon/favorite.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                お気に入りリスト
                            </a>
                        </li>
                        <li class="global-nav-sub__item">
                            <a href="/song/account/resign">
                                <img src="/storage/icon/withdrawal.png" height="20" style="position: relative; top: 2px;">&nbsp;
                                退会
                            </a>
                        </li>
                    </ul>
                <li class="global-nav__item">
                    <a href="/song/song_search">
                        <img src="/storage/icon/other_song.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        他の会員が投稿した歌唱曲
                    </a>
                </li>
                <li class="global-nav__item">
                    <a href="/song/request">
                        <img src="/storage/icon/request.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        お問い合わせ・要望
                    </a>
                </li>
                <li class="global-nav__item" id="yohaku">
                    <a href="/song/logout">
                        <img src="/storage/icon/exit.png" height="20" style="position: relative; top: 2px;">&nbsp;
                        ログアウト
                    </a>
                </li>
            @endauth
        </ul>
    </nav>
</div>
@endsection