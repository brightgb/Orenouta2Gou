@extends('layout.common')

@include('layout.song.header')

@section('content')
<div style="width: 90vw; margin-bottom: 100px;">
    ユーザーIDが発行されました。<br>
    「 <strong>{{ $userid }}</strong> 」<br>
    <span style="background: linear-gradient(transparent 50%, orange 50%);">パスワードと合わせて、ログインの際に必要となります</span>ので、忘れないようにご注意ください。<br><br>

    <button onclick="goPage()">ログインページに進む</button>
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    button {
        margin-top: 20px;
        height: 35px;
        background-color: teal;
        border: 1px solid gray;
        border-radius: 7px;
        font-size: large;
        cursor: pointer;
    }
</style>

<script>
    function goPage() {
        var userid = '<?php echo $userid; ?>';
        var password = '<?php echo $password; ?>';
        location.href = '/song/login?userid=' + userid + '&password=' + password;
    }
</script>
@endsection