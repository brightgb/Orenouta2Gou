{{-- 件数表示 チェックボックス付き --}}
<div class="from_to_count_check">
    <div>{{ $paginator->firstItem() }}～{{ $paginator->lastItem() }}表示&nbsp;/&nbsp;{{ $paginator->total() }}件中</div>
    <div class="right"><label for="all_check"><input type="checkbox" id="all_check">全選択</label></div>
</div>
<hr color="#CCCCCC" />
{{-- 前へ、次へ --}}
<div align="center">
    <a name="up"></a>
    <div id="pagerBtn">
        @if (!$paginator->onFirstPage())
            <div><a href="{{ $paginator->appends(request()->except('page'))->previousPageUrl() }}"><img src="/img/old/icon/btnPre.gif">前へ</a></div>
        @else
            <div><span><img src="/img/old/icon/btnPre50.gif">前へ</span></div>
        @endif
        <div class="updw">|&nbsp;<a href="#dw">↓</a>&nbsp;|</div>
        @if ($paginator->hasMorePages())
            <div><a href="{{ $paginator->appends(request()->except('page'))->nextPageUrl() }}">次へ<img src="/img/old/icon/btnNext.gif"></a></div>
        @else
            <div><span>次へ<img src="/img/old/icon/btnNext50.gif"></span></div>
        @endif
    </div>
</div>