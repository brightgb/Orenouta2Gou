<div class="bottom_pagination" style="margin-bottom:8px;">
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
</div>