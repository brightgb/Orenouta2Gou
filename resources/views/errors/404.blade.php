@extends('layout.common')

@php
    $title = '存在しないページ';
@endphp

@section('content')
<div style="text-align: center;">
    <p>申し訳ございません。<br/>アクセスしようとされたページが見つかりませんでした。</p>
        <div>
            <a href="#" onclick="javascript:window.history.back(-1); return false;"
               style="text-decoration: none;">
                戻る
            </a>
        </div>
</div>
@endsection