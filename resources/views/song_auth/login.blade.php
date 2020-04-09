@extends('layout.common')

@include('layout.song.header')

@section('content')
<div class="regist_form">
    <form method="post">
        {{ csrf_field() }}
        <div class="input_area" style="margin-top: 10px;">
            <strong>ユーザーID</strong><br>
            <input type="text" name="userid" value="{{ old('userid', $userid) }}">
            @if ($errors->has('userid'))
                <span class="error_message">{{ $errors->first('userid') }}</span>
            @endif
        </div>
        <div class="input_area" style="margin-top: 20px;">
            <strong>パスワード（半角英数字4～8文字）</strong><br>
            <input type="text" maxlength="8" name="password" value="{{ old('password', $password) }}">
            @if ($errors->has('password'))
                <span class="error_message">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <input class="input_button" type="submit" value="ロ グ イ ン">
    </form>
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    input {
        width: 100%;
        border: 2px solid gray;
        border-radius: 5px;
        height: 30px;
    }
    .regist_form {
        width: 95vw;
        margin-bottom: 100px;
    }
    .input_area {
        text-align: left;
    }
    .input_button {
        margin-top: 30px;
        width: 50%;
        height: 35px;
        background-color: teal;
        border: 1px solid gray;
        border-radius: 7px;
        font-size: large;
        cursor: pointer;
    }
    .error_message {
        color: red;
        font-weight: bold;
        font-size: small;
    }
</style>
@endsection