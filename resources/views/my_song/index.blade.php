@extends('layout.common')

@include('layout.header')

@section('content')
<style>
body {
    background: url({{$image}});
    background-position: center 40px;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-color: gray;
    background-size: 100vw 100vh;
}
</style>
@endsection