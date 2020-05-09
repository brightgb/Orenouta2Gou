@extends('layout.common')

@include('layout.song.header')

@section('content')
    {{-- スマホ表示 --}}
    @if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
         $device == config('constKey.DEVICE_TYPE.IOS'))
         {{-- 未ログイン --}}
        @guest
        <div style="width: 90vw; position: absolute; top: 0; right: 0; bottom: 0; left: 0; margin: 60% auto auto auto;">
            <div style="width: 100%; height: 50px; margin-bottom: 7%;">
                <a href="/song/about_site">
                    <button style="width: 100%; height: 100%;">
                        俺の歌を育てろ とは？
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px; margin-bottom: 7%;">
                <a href="/song/info">
                    <button style="width: 100%; height: 100%;">
                        新着情報
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px; margin-bottom: 7%;">
                <a href="/song/song_list">
                    <button style="width: 100%; height: 100%;">
                        他の会員が投稿した歌唱曲
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px; margin-bottom: 7%;">
                <a href="/song/regist">
                    <button style="width: 100%; height: 100%;">
                        会員登録 <strong>無料</strong>
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px;">
                <a href="/song/login">
                    <button style="width: 100%; height: 100%;">
                        ログイン
                    </button>
                </a>
            </div>
        </div>
        @endguest

        {{-- ログイン状態 --}}
        @auth
        <div style="width: 90vw; position: absolute; top: 0; right: 0; bottom: 0; left: 0; margin: 60% auto auto auto;">
            <div style="width: 100%; height: 50px; margin-bottom: 10%;">
                <a href="/song/info">
                    <button style="width: 100%; height: 100%;">
                        新着情報
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px; margin-bottom: 10%;">
                <a href="/song/song_search">
                    <button style="width: 100%; height: 100%;">
                        他の会員が投稿した歌唱曲
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px; margin-bottom: 10%;">
                <a href="/song/request">
                    <button style="width: 100%; height: 100%;">
                        お問い合わせ・要望
                    </button>
                </a>
            </div>
            <div style="width: 100%; height: 50px;">
                <a href="/song/logout">
                    <button style="width: 100%; height: 100%;">
                        ログアウト
                    </button>
                </a>
            </div>
        </div>
        @endauth
    <style>
        body {
            background: url({{$image}});
            background-position: center 40px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: gray!important;
            background-size: 100vw 100vh;
        }
        button {
            font-size: large;
            border-radius: 10px;
            cursor: pointer;
        }
        button:hover { background-color: royalblue; }
    </style>


    {{-- ＰＣ表示 --}}
    @else
        {{-- 未ログイン --}}
        @guest
        <div style="display: inline-flex; width: 60vw; height: 200px; position: absolute; top: 0; right: 0; bottom: 0; left: 0; margin: auto auto 5% auto;">
            <div style="width: 50%; height: 100%;">
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/regist">
                        <button style="width: 50%; height: 50%; position: relative; top: 25%;">
                            会員登録 <strong>無料</strong>
                        </button>
                    </a>
                </div>
                <div style="display: inline-flex; width: 100%; height: 50%;">
                    <div style="width: 50%; height: 100%; text-align: center;">
                        <a href="/song/info">
                            <button style="width: 90%; height: 50%; position: relative; top: 25%; margin-right: 10%;">
                                新着情報
                            </button>
                        </a>
                    </div>
                    <div style="width: 50%; height: 100%; text-align: center;">
                        <a href="/song/login">
                            <button style="width: 90%; height: 50%; position: relative; top: 25%; margin-right: 10%;">
                                ログイン
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div style="width: 50%; height: 100%; text-align: center;">
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/about_site">
                        <button style="width: 75%; height: 50%; position: relative; top: 25%;">
                            俺の歌を育てろ とは？
                        </button>
                    </a>
                </div>
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/song_list">
                        <button style="width: 75%; height: 50%; position: relative; top: 25%;">
                            他の会員が投稿した歌唱曲
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endguest

        {{-- ログイン状態 --}}
        @auth
        <div style="display: inline-flex; width: 60vw; height: 200px; position: absolute; top: 0; right: 0; bottom: 0; left: 0; margin: auto auto 5% auto;">
            <div style="width: 50%; height: 100%;">
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/info">
                        <button style="width: 50%; height: 50%; position: relative; top: 25%;">
                            新着情報
                        </button>
                    </a>
                </div>
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/logout">
                        <button style="width: 50%; height: 50%; position: relative; top: 25%;">
                            ログアウト
                        </button>
                    </a>
                </div>
            </div>
            <div style="width: 50%; height: 100%; text-align: center;">
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/request">
                        <button style="width: 75%; height: 50%; position: relative; top: 25%;">
                            お問い合わせ・要望
                        </button>
                    </a>
                </div>
                <div style="width: 100%; height: 50%; text-align: center;">
                    <a href="/song/song_search">
                        <button style="width: 75%; height: 50%; position: relative; top: 25%;">
                            他の会員が投稿した歌唱曲
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endauth
    <style>
        body {
            background: url({{$image}});
            background-position: center 40px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #555555!important;
            background-size: contain;
        }
        button {
            font-size: large;
            border-radius: 10px;
            cursor: pointer;
        }
        button:hover { background-color: royalblue; }
    </style>
    @endif
@endsection