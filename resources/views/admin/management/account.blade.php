@extends('layout.admin.admin_common')

@section('title', 'アカウント管理')
@section('content_header', 'アカウント管理')

@section('content')
    @if (session('success'))
    <div>
        <p><strong><center>{{ session('success') }}</center></strong></p>
    </div>
    @endif
<div style="width: 90%; margin: 0 auto 30px auto;">
    <a href="/admin/account/create"><button class="regist">新規登録</button></a>
</div>
<div class="result_aria">
    <table id="serch_form2" style="width: 100%; table-layout: fixed;">
        <tr style="height: 30px;">
            <th style="text-align: center;">アカウント名</th>
            <th style="text-align: center;">ログインID</th>
            <th style="text-align: center;">パスワード</th>
            <th style="text-align: center;">編集</th>
            <th style="text-align: center;">削除</th>
        </tr>
        @foreach ($accounts as $key => $value)
            <tr style="text-align: center; height: 50px;">
                <td>
                    {{ $value['name'] }}
                </td>
                <td>
                    {{ $value['userid'] }}
                </td>
                <td>
                    {{ $value['password'] }}
                </td>
                <td>
                    <a href="/admin/account/edit/{{ $value['id'] }}">
                        <button class="edit">編集</button>
                    </a>
                </td>
                <td>
                    <form method="post" action="/admin/account/delete" onSubmit="return check()">
                        {{ csrf_field() }}
                        <input type="hidden" name="delete_id" value="{{ $value['id'] }}">
                        <button type="submit" class="delete">削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/default.form.css') }}">
<style>
    .regist {
        width: 100px;
        height: 40px;
        border-radius: 5px;
        background-color: teal;
        color: #ffffff;
        font-size: large;
    }
    .result_aria {
        width: 90%;
        margin: 0 auto;
    }
    .edit, .delete {
        width: 50px;
        height: 30px;
        border-radius: 10px;
        background-color: orange;
        color: black;
    }
</style>
@stop

@section('js')
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#C').addClass('active');
    $('#8').addClass('active');

    function check() {
        if (window.confirm('削除してよろしいですか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@stop