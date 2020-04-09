@extends('layout.common')

@include('layout.song.header')

@section('content')
    @if ($device == config('constKey.DEVICE_TYPE.ANDROID') ||
         $device == config('constKey.DEVICE_TYPE.IOS'))
    <style> /* スマホ表示 */
        body {
            background: url({{$image}});
            background-position: center 40px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: gray!important;
            background-size: 100vw 100vh;
        }
    </style>
    @else
    <style> /* ＰＣ表示 */
        body {
            background: url({{$image}});
            background-position: center 40px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #555555!important;
            background-size: contain;
        }
    </style>
    @endif
@endsection