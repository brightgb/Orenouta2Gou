{{-- 前へ、次へ --}}
<div align="center">
    <a name="dw"></a>
    <div id="pagerBtn">
        @if (!$paginator->onFirstPage())
            <div><a href="{{ $paginator->appends(request()->except('page'))->previousPageUrl() }}"><img src="/img/old/icon/btnPre.gif">前へ</a></div>
        @else
            <div><span><img src="/img/old/icon/btnPre50.gif">前へ</span></div>
        @endif
        <div class="updw">|&nbsp;<a href="#up">↑</a>&nbsp;|</div>
        @if ($paginator->hasMorePages())
            <div><a href="{{ $paginator->appends(request()->except('page'))->nextPageUrl() }}">次へ<img src="/img/old/icon/btnNext.gif"></a></div>
        @else
            <div><span>次へ<img src="/img/old/icon/btnNext50.gif"></span></div>
        @endif
    </div>
</div>
<hr color="#CCCCCC">
{{-- 番号 ページネーション --}}
@if ($paginator->hasPages())
    <div align="center">{{ $paginator->appends(request()->except('page'))->render('layouts.pagination.numbers') }}</div>
@endif
<hr color="#CCCCCC">
{{-- 件数表示 --}}
<div id="from_to_count">
    <p class="right pa_lr4">{{ $paginator->firstItem() }}～{{ $paginator->lastItem() }}表示&nbsp;/&nbsp;{{ $paginator->total() }}件中</p>
</div>
<hr color="#CCCCCC">
{{-- 5ページずつページング --}}
@if ($paginator->total() > $paginator->perPage()*5)
    <div class="count_btn">
        @if ($paginator->firstItem() > $paginator->perPage()*5)
            <a href="{{ $paginator->appends(request()->except('page'))->url($paginator->currentPage()-5) }}"><button type=button>{{ $paginator->perPage()*5 }}件戻る</button></a>
        @else
            <button disabled>{{ $paginator->perPage()*5 }}件戻る</button>
        @endif
        @if ($paginator->lastItem() + $paginator->perPage()*5 <= $paginator->total())
            <a href="{{ $paginator->appends(request()->except('page'))->url($paginator->currentPage()+5) }}"><button type=button>{{ $paginator->perPage()*5 }}件進む</button></a>
        @else
            <button disabled>{{ $paginator->perPage()*5 }}件進む</button>
        @endif
    </div>
@endif