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
        ＜ コメント欄 ＞
    </span>
</div>

{{-- スクロール部分 --}}
@if (count($advice_list) == 0)
    <div style="padding-top: 100px; margin: 150px 0 70px 0; width: 100%; text-align: center; clear: both;">
        <div style="padding: 10px; margin: 0 1% 50px 2%; width: 90%; border: 1px solid #333333; border-radius: 10px; background-color: silver; display: inline-block; text-align: center;">
            まだ何も書き込まれていません
        </div>
    </div>
@else
    <div style="padding-top: 70px; margin: 150px 0 100px 0; width: 100%; text-align: center; clear: both;">
        <div id="list" style="width: 100%; margin-bottom: 30px; height: auto;">
        @foreach ($advice_list as $key => $value)
            <div class="li" @if ($value['nice_flg'] == 0) id="{{ $value['id'] }}" data-val="{{ $value['member_id'] }}" @endif style="background-color: #FFFF99; border-radius: 10px; border: 1px solid #333333; padding: 5px 1%; margin: 20px 5%;">
                <table>
                    <tr>
                        <td style="width: 5%; vertical-align: middle;">
                            <img style="height: 30px; margin: 0px; cursor: pointer;"
                            @if ($value['nice_flg'] == 0) src="/storage/icon/before_nice1.png"
                            @else src="/storage/icon/after_nice1.png" @endif>
                            <img style="height: 17px; margin: 0 -8px 0 -15px; cursor: pointer;"
                            @if ($value['nice_flg'] == 0) src="/storage/icon/before_nice2.png"
                            @else src="/storage/icon/after_nice2.png" @endif>
                        </td>
                        <td>
                            <div style="margin-left: 5%; text-align: left;">
                                {!! $value['advice'] !!}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
        </div>
    </div>
@endif

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
        height: 1.5px;
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
</style>

<script>
    // １０個ずつコメント表示
    $(function() {
        //分割したい個数を入力
        var division = 10;
        //要素の数を数える
        var divlength = $('#list .li').length;
        if (divlength <= 10) {
            return;
        }
        //分割数で割る
        dlsizePerResult = divlength / division;
        //分割数 刻みで後ろにmorelinkを追加する
        for (i=1; i<=dlsizePerResult; i++) {
            $('#list .li').eq(division*i-1)
                .after('<div class="morelink link' + i +'">続きを表示</div>');
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
    // いいねを付ける
    const last = "<?php echo $last; ?>";
    const song_id = "<?php echo $song_id; ?>";
    for (var i=1; i<=last; i++) {
        const Id = i;
        $('#'+i+' > table tr td img').click(function() {
            var target = document.getElementById(Id);
            if (!target || !target.getAttribute('id') || !target.getAttribute('data-val')) {
                return;
            }
            var record_id = target.getAttribute('id');
            var member_id = target.getAttribute('data-val');
            if (!confirm('「役に立ったアドバイス」 として認定しますか？')) return;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/song/api/send_nice",
                    data: {record_id : record_id,
                           song_id : song_id,
                           member_id : member_id},
                })
                .done(function(ret) {
                    // data-val を不正に打ち換えて送信
                    if (ret.status == 'NG') {
                        alert('通信に失敗しました。');  // 管理側の強制削除と同時だった場合を考慮
                        location.reload();
                    }
                    // 成功
                    else {
                        // 該当のアイコンをいいね済みに変える
                        var src = $('#'+ret.result+' > table tr td img:first').attr('src').replace('before', 'after');
                        $('#'+ret.result+' > table tr td img:first').attr('src', src);
                        var src = $('#'+ret.result+' > table tr td img:first').next().attr('src').replace('before', 'after');
                        $('#'+ret.result+' > table tr td img:first').next().attr('src', src);
                        alert('選定しました。');
                        var obj = document.getElementById(ret.result)
                        obj.removeAttribute('id');
                        obj.removeAttribute('data-val');
                    }
                })
                .fail(function(err) {
                    alert('通信に失敗しました。');
                });
        });
    }
</script>
@endsection