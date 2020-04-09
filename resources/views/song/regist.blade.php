@extends('layout.common')

@include('layout.song.header')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="regist_form">
    下記項目を入力するだけです。<br>
    <span style="background: linear-gradient(transparent 50%, orange 50%);">ユーザーIDとパスワードはログインの際に必要</span>なので忘れないようにしてください。<br>
    登録後はサイト内コンテンツが全て無料で利用可能になります。<br><br>
    <div class="input_area">
        <strong>ニックネーム（15文字以内）</strong><br>
        ※ 他の会員が不快になるような名前はご遠慮ください。<br>
        <input type="text" maxlength="15" id="nickname">
        <span class="error_message" id="err_nickname"></span>
    </div>
    <div class="input_area" style="margin-top: 10px;">
        <strong>ユーザーID</strong><br>
        <center>※ 登録完了後に取得されます。</center>
    </div>
    <div class="input_area" style="margin-top: 10px;">
        <strong>パスワード（半角英数字4～8文字）</strong><br>
        <input type="text" maxlength="8" id="password_org">
        <span class="error_message" id="err_password"></span>
    </div>
    <button class="input_button">登　録</button>
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
    $('.input_button').click(function() {
        if (!confirm('この内容で、よろしいですか？')) return;
            var nickname = $('#nickname').val();
            var password_org = $('#password_org').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/song/api/regist",
                data: {nickname : nickname,
                       password_org : password_org},
            })
            .done(function(ret) {
                // バリデーションエラー
                if (ret.status == 'NG') {
                    // エラーメッセージを表示させる
                    $('#err_nickname').empty();
                    if (ret.errors.all_space1) {
                        $('#err_nickname').prepend(ret.errors.all_space1);
                    } else if (ret.errors.nickname) {
                        $('#err_nickname').prepend(ret.errors.nickname[0]);
                    }
                    $('#err_password').empty();
                    if (ret.errors.all_space2) {
                        $('#err_password').prepend(ret.errors.all_space2);
                    } else if (ret.errors.password_org) {
                        $('#err_password').prepend(ret.errors.password_org[0]);
                    }
                }
                // 成功
                else {
                    alert('登録が完了しました。');
                    // ユーザーID確認ページへ遷移
                    location.href = '/song/regist' + ret.userid;
                }
            })
            .fail(function(err) {
                alert('通信に失敗しました。');
            });
    });
</script>
@endsection