@extends('layout.common')

@include('layout.song.header')

@section('content')
<div style="width: 90vw; margin: 0 auto; padding-bottom: 100px;">
    こちらは、退会申請フォームです。<br>
    退会に際しての違約金等は発生しませんが、<span style="color: red; font-weight: bold;">このアカウントを再度利用しての活動復帰は不可能</span>になります。<br>
    既存のYoutubeアカウントには影響はありません。<br>
    それでも宜しければ、下記のボタンを押下してください。<br><br>
    <form method="post" action="" onSubmit="return check()">
        {{ csrf_field() }}
        <input class="btn" type="submit" value="送 信">
    </form>
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    .btn {
        width: 25%;
        height: 40px;
        border-radius: 10px;
        background-color: #3c8dbc;
        border:solid 1px #3c8dbc;
        cursor:pointer;
    }
</style>

<script>
    function check() {
        if (window.confirm('本当に退会しますか？')) {
            return true;
        }
        else {
            return false;
        }
    }
</script>
@endsection