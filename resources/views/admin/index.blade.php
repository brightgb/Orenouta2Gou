@extends('layout.admin.admin_common')

@section('title', '管理画面トップ')
@section('content_header', '管理画面トップ')

@section('content')
@stop

@section('css')
@stop

@section('js')
<script>
    $('.sidebar-menu li').removeClass('active');
    $('#1').addClass('active');
</script>
@stop