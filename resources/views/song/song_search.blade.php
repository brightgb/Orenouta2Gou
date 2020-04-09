@extends('layout.common')

@include('layout.song.header')

@section('content')
<form method="post" action="" style="margin-bottom: 80px;">
    {{ csrf_field() }}
    <button>検 索 す る</button>

    <span class="search_line">
        ＜ 条件を指定 ＞
    </span>

    <div class="search_item_check">
        <input name="favorite_flg" type="checkbox" value="1" @if (!empty($search_data['favorite_flg'])) checked @endif>&ensp;お気に入り登録中の会員のみ表示
    </div>

    <div class="search_item_check">
        <input name="new_flg" type="checkbox" value="1" @if (!empty($search_data['new_flg'])) checked @endif>&ensp;新曲のみ表示<br>
        　&ensp;※ 投稿後、1週間以内の歌が対象
    </div>

    <div class="search_item_check">
        <input name="no_advice_flg" type="checkbox" value="1" @if (!empty($search_data['no_advice_flg'])) checked @endif>&ensp;未アドバイスの歌唱曲のみ表示
    </div>

    <div class="search_item_text">
        <label>会員のニックネーム</label><br>
        <div style="display: table; width: 100%">
            <div style="display: table-cell;">
                <input type="text" name="nickname" value="{{ !empty($search_data['nickname'])? $search_data['nickname']: '' }}">
            </div>
            <div style="display: table-cell; width: 70px;">&ensp;と一致</div>
        </div>
    </div>

    <div class="search_item_text">
        <label>曲名</label><br>
        <div style="display: table; width: 100%">
            <div style="display: table-cell;">
                <input type="text" name="song_title" value="{{ !empty($search_data['song_title'])? $search_data['song_title']: '' }}">
            </div>
            <div style="display: table-cell; width: 70px;">&ensp;を含む</div>
        </div>
    </div>

    <button style="margin-top: 35px;">検 索 す る</button>
</form>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    button {
        width: 50%;
        height: 35px;
        font-size: large;
        border-radius: 10px;
        background-color: #3c8dbc;
        border: solid 1px #3c8dbc;
        cursor: pointer;
        margin-top: 10px;
    }
    .search_line {
        display: flex;
        align-items: center;
        margin: 20px 4% 0 2%;
    }
    .search_line:before, .search_line:after {
        content: "";
        flex-grow: 1;
        height: 1.5px;
        background: black;
        margin: 1em;
    }
    .search_item_text {
        text-align: left;
        width: 90vw;
        margin: 10px 1% 0 2%;
    }
    .search_item_text > div > div > input {
        width: 100%;
        border: 2px solid gray;
        border-radius: 5px;
        height: 30px;
        text-indent: 5px;
    }
    .search_item_check {
        text-align: left;
        margin: 10px 1% 0 2%;
    }
    .search_item_check > input {
        width: 20px;
        height: 20px;
        position: relative;
        top: 4px;
    }
</style>
@endsection