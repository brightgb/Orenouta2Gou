@extends('layout.common')

@include('layout.song.header')

@section('content')
{{-- 固定部分 --}}
<div style="margin-top: -110px; width: 100vw; position: fixed; top: 150px; z-index: 9998; background-color: silver;">
    {{ $data->links('layout.pagination.pagination') }}
    <hr size="1" color="black" style="margin-top: 20px;" noshade>
</div>

{{-- スクロール部分 --}}
<div style="padding-top: 50px; margin: 100px 0; width: 100%;">
    @if ($data->total() == 0)
        <div style="padding: 10px; margin: 0 1% 0 2%; width: 90%; border: 1px solid #333333; border-radius: 10px; background-color: silver; display: inline-block; text-align: center;">
            該当するデータが見つかりません
        </div>
    @else
        @foreach ($data->items() as $key => $item)
            @if ($key == 0)
            <div style="margin: 0 1% 10px 1%; padding: 5px;">
                <div style="font-size: x-small; margin-bottom: 5px;">{{ $item['notify_date'] }}</div>
                <span style="font-size: small;">{!! $item['message'] !!}</span>
            </div>
            @else
            <div style="margin: 10px 1%; padding: 5px;">
                <div style="font-size: x-small; margin-bottom: 5px;">{{ $item['notify_date'] }}</div>
                <span style="font-size: small;">{!! $item['message'] !!}</span>
            </div>
            @endif
            <hr size="1" color="black" noshade>
        @endforeach
    @endif
</div>

<style>
body {
    box-sizing: border-box;
}
</style>
@endsection