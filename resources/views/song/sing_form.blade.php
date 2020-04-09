@extends('layout.common')

@include('layout.song.header')

@section('content')
<div class="regist_form">
    下記項目を全て入力してください。<br><br>
    <form method="post" action="" onSubmit="return check()">
        {{ csrf_field() }}
        <div class="input_area">
            <strong>歌唱曲のタイトル（100文字以内）</strong><br>
            <input type="text" maxlength="100" name="name" value="{{ old('name') }}">
            @if ($errors->has('all_space1'))
                <span class="error_message">{{ $errors->first('all_space1') }}</span>
            @elseif ($errors->has('name'))
                <span class="error_message">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="input_area" style="margin-top: 10px;">
            <strong>投稿者からのコメント（100文字以内）</strong><br>
            <center>※ 歌う際に心掛けた点や助言してほしい点などをお書きください。</center>
            <textarea type="text" maxlength="100" name="comment">{{ old('comment') }}</textarea>
            @if ($errors->has('all_space2'))
                <span class="error_message">{{ $errors->first('all_space2') }}</span>
            @elseif ($errors->has('comment'))
                <span class="error_message">{{ $errors->first('comment') }}</span>
            @endif
        </div>
        <div class="input_area" style="margin-top: 10px;">
            <strong>動画ID</strong><br>
            <center>※ 例：https://youtube/watch?v=file_name のとき<br>
                    　ｖ=以降の、file_name 部分を入力します。</center>
            <input type="text" maxlength="128" name="youtube" value="{{ old('youtube') }}">
            @if ($errors->has('all_space3'))
                <span class="error_message">{{ $errors->first('all_space3') }}</span>
            @elseif ($errors->has('youtube'))
                <span class="error_message">{{ $errors->first('youtube') }}</span>
            @endif
        </div>
        <input type="submit" class="input_button" value="投　稿">
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
        font-family: sans-serif;  /* 字体を揃えるため */
    }
    textarea {
        width: 98%;
        border: 2px solid gray;
        border-radius: 5px;
        height: 75px;
        font-family: sans-serif;  /* 字体を揃えるため */
    }
    .regist_form {
        width: 95vw;
        margin-bottom: 100px;
    }
    .input_area {
        text-align: left;
    }
    .input_button {
        margin-top: 20px;
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

<script>
    function check() {
        if (window.confirm('この内容でよろしいですか？')) {
            return true;
        }
        else{
            return false;
        }
    }
</script>
@endsection