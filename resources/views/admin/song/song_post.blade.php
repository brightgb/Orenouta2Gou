@extends('layout.admin.admin_common')

@section('title', '歌唱曲の投稿')
@section('content_header', '歌唱曲の投稿')

@section('content')
    @if (session('error'))
    <div>
        <p><font color="red"><strong><center>{{ session('error') }}</center></strong></font></p>
    </div>
    @endif
    @if (session('success'))
    <div>
        <p><strong><center>{{ session('success') }}</center></strong></p>
    </div>
    @endif
<div class="search_aria">
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table id="serch_form1" border="1">
            <tr>
                <th>タイトル</th>
                <td>
                    <input type="text" name="title" size="30" required>
                </td>
            </tr>
            <tr>
                <th>紹介文</th>
                <td>
                    <textarea name="comment" cols="50" rows="5" required></textarea>
                </td>
            </tr>
            <tr>
                <th>動画ＩＤ</th>
                <td>
                    <input type="text" name="file" size="30" required><br>
                    ※例：https://youtube/watch?v=file_name のとき<br>
                    　ｖ=以降の、「file_name」部分を入力する
                </td>
            </tr>
        </table>
        <div>
            <input class="btn" type="submit" value="登録">
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
    $('#A').addClass('active');
    $('#4').addClass('active');
</script>
@stop