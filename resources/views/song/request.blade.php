@extends('layout.common')

@include('layout.song.header')

@section('content')
<div style="width: 90vw; margin: 0 auto; padding-bottom: 100px;">
    @if (session('success'))
        <div class="rel">
            {{ session('success') }}
        </div>
    @endif
    こちらは、お問い合わせ・要望フォームです。<br>
    サイトを閲覧していてお気づきになった点などございましたら、お気軽に送信ください。<br><br>
    <form method="post" onSubmit="return check()">
        {{ csrf_field() }}
        <p>最大３００文字</p>
        <textarea name="question" style="width: 95%; height: 100px;" maxlength="300" required></textarea>
        <br>
        @if ($errors->has('all_space'))
            <span style="color: red; font-size: small;">
                <strong>{{ $errors->first('all_space') }}</strong>
            </span>
        @elseif ($errors->has('question'))
            <span style="color: red; font-size: small;">
                <strong>{{ $errors->first('question') }}</strong>
            </span>
        @endif
        <br>
        <input class="btn" type="submit" value="送 信">
    </form>
    <div class="q_a" onclick="q_a()">
        <span style="font-weight: bold; float: left;">&nbsp;＞</span>
        <span style="clear: both;">送信前のＱ＆Ａ</span>
    </div>
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    .rel {
        background-color: #ff9900;
        width: 90%;
        line-height: 30px;
        margin: 0 auto 10px auto;
        vertical-align: middle;
    }
    .btn {
        width: 25%;
        height: 40px;
        border-radius: 10px;
        background-color: #3c8dbc;
        border:solid 1px #3c8dbc;
        cursor:pointer;
    }
    .q_a {
        margin-top: 10%;
        border: solid 1px gray;
        border-radius: 5px;
        width: 95%;
        line-height: 30px;
        vertical-align: middle;
        background-color: gray;
        cursor: pointer;" 
    }
</style>

<script>
    function check() {
        if (window.confirm('この内容で送信しますか？')) {
            return true;
        }
        else {
            return false;
        }
    }
    function q_a() {
        location.href = "/song/about_request";
    }
</script>
@endsection