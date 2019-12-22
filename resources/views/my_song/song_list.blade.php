@extends('layout.common')

@include('layout.header')

@section('content')
{{-- 固定部分 --}}
<div class="absolute_part">
    {{ $data->links('layout.pagination.pagination') }}
    <div class="cp_ipselect cp_sl01">
        <select onchange="location.href=value;">
            <option value="/song_list?sort=1" @if ($sort == 1) selected @endif>
                投稿の最新順
            </option>
            <option value="/song_list?sort=2" @if ($sort == 2) selected @endif>
                投稿の古い順
            </option>
            <option value="/song_list?sort=3" @if ($sort == 3) selected @endif>
                コメントの多い順
            </option>
            <option value="/song_list?sort=4" @if ($sort == 4) selected @endif>
                コメントの少ない順
            </option>
        </select>
    </div>
    <hr size="1" color="black" style="margin: 60px 5% 0 1%;" noshade>
</div>

{{-- スクロール部分 --}}
<div style="padding-top: 100px; margin: 100px 0; width: 100%;">
    @if ($data->total() == 0)
        <div class="no_data">
            該当するデータが見つかりません
        </div>
    @else
        @foreach ($data->items() as $key => $item)
            @if ($key == 0)
            <div class="first_list">
            @else
            <div class="from_next_list">
            @endif
                <div style="text-align: left; width: 70%; display: table-cell;">
                    @if ($item['new_flg'])
                        <img src="/storage/icon/new_song.png" class="new_song">
                    @endif
                        <span style="font-size: small;">投稿日：{{ $item['created_at'] }}</span>
                </div>
                <div style="text-align: right; width: 25%; display: table-cell;">
                    <img src="/storage/icon/advice.png" class="advice">
                    <span style="font-size: small;">{{ $item['advice_cnt'] }}</span>
                </div>
            </div>
            <div class="list_detail">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 15%; padding-right: 1%; text-align: right;">
                            <img src="/storage/icon/song_item.png">
                        </td>
                        <td class="detail_text">
                            <a href="/song_detail/{{ $item['id'] }}" style="font-weight: bold; text-decoration: none; color: blue;">
                                {{ $item['title'] }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%; padding-right: 1%; text-align: right;">
                            <img src="/storage/icon/admin_comment.png" style="height: 30px;">
                        </td>
                        <td class="detail_text">
                            <span style="font-size: small;">{!! $item['comment'] !!}</span>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    @endif
</div>

<style>
body {
    box-sizing: border-box;
}
.cp_ipselect {
    overflow: hidden;
    text-align: center;
}
.cp_ipselect select {
    width: 100%;
    padding-right: 1em;
    cursor: pointer;
    text-indent: 0.01px;
    text-overflow: ellipsis;
    border: none;
    outline: none;
    background: transparent;
    background-image: none;
    box-shadow: none;
    -webkit-appearance: none;
    appearance: none;
}
.cp_ipselect select::-ms-expand {
    display: none;
}
.cp_ipselect.cp_sl01 {
    position: absolute;
    top: 80px;
    right: 5%;
    font-size: 110%;
    border: 1px solid black;
    border-radius: 10px;
    background: #DDFFFF;
}
.cp_ipselect.cp_sl01::before {
    position: absolute;
    top: 1.0em;
    right: 0.9em;
    width: 0;
    height: 0;
    padding: 0;
    content: '';
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid black;
    pointer-events: none;
}
.cp_ipselect.cp_sl01 select {
    padding: 10px 40px 10px 10px;
    color: black;
    background-color: #DDFFFF;
}
.absolute_part {
    margin-top: -110px;
    width: 100vw;
    position: fixed; top: 150px;
    z-index: 9998;
    background-color: silver;
}
.no_data {
    padding: 10px;
    margin: 0 1% 10px 2%;
    width: 90%;
    border: 1px solid #333333;
    border-radius: 10px;
    background-color: silver;
    display: inline-block;
    text-align: center;
}
.first_list {
    width: 95%;
    margin: 0 1%;
    display: inline-table;
    table-layout: fixed;
}
.from_next_list {
    width: 95%;
    margin: 30px 1% 0 1%;
    display: inline-table;
    table-layout: fixed;
}
.new_song, .advice {
    width: auto;
    height: 20px;
    position: relative;
    top: 4px;
    left: 0;
}
.list_detail {
    background-color: #FFFF33;
    border-radius: 10px;
    border: 1px solid #333333;
    margin: 0 1%;
    padding: 1%;
    width: 95%;
}
.detail_text {
    width: 80%;
    word-break: break-all;
    padding-left: 1%;
    text-align: left;
}
</style>
@endsection