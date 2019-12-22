@extends('layout.admin.admin_common')

@section('title', 'アカウント編集')
@section('content_header', 'アカウント編集')

@section('content')
    @if (!empty($errors))
        @foreach ($errors->all() as $error)
            <div>
                <p><font color="red"><strong><center>{{ $error }}</center></strong></font></p>
            </div>
        @endforeach
    @endif
    @if (session('space_error'))
        <div>
            <p><font color="red"><strong><center>{{ session('space_error') }}</center></strong></font></p>
        </div>
    @endif
<div class="search_aria">
    <form method="post" action="/admin/account/update">
        {{ csrf_field() }}
        <input type="hidden" name="data_id" value="{{ $account->id }}">
        <table id="serch_form1" border="1">
            <tr>
                <th>アカウント名</th>
                <td>
                    <input type="text" name="name" size="30" value="{{ old('name', $account->name) }}" required>
                </td>
            </tr>
            <tr>
                <th>ログインID</th>
                <td>
                    <input type="text" name="userid" size="30" value="{{ old('userid', $account->userid) }}" required>　半角英数
                </td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>
                    <input type="text" name="password_org" size="30" value="{{ old('password_org', $account->password_org) }}" required>　半角英数
                </td>
            </tr>
        </table>
        <div>
            <button class="btn">更新</button>
        </div>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/default.form.css') }}">
<style>
    .search_aria {
        margin: 0 auto;
        padding: 10px 0 0 10px;
    }
    tr th {
        width: 100px;
        text-align: center;
    }
    tr td {
        width: 300px;
    }
    .btn {
        margin-top: 10px;
        width: 70px;
        height: 40px;
        border-radius: 10px;
        background-color: #3c8dbc;
        color: #ffffff;
        font-size: large;
    }
</style>
@stop

@section('js')
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#C').addClass('active');
    $('#10').addClass('active');
</script>
@stop