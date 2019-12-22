{{-- 件数表示（管理側の通常配列で使用）--}}
<div id="pagerNum" style="display: flex; font-size: normal;">
    {{-- 最初のページへ移動 --}}
    @if ($paginator->currentPage() > 3)
        <div class="no_active">
            <a href="{{ $paginator->url(1) }}"> < </a>
        </div>
    @endif
    {{-- 現在のページを含む5つまでのリンクを表示 --}}
    @foreach ($elements as $element)
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($paginator->currentPage() + 2 < 5)
                    @if ($page > 5)
                        @continue
                    @endif
                @elseif ($paginator->currentPage() + 2 > $paginator->lastPage())
                    @if ($paginator->lastPage() - $page > 4)
                        @continue
                    @endif
                @else
                    @if (abs($page - $paginator->currentPage()) > 2)
                        @continue
                    @endif
                @endif
                @if ($page == $paginator->currentPage())
                    <div class="on_active">
                        <span class="on_active_a">{{ $page }}</span>
                    </div>
                @else
                    <div class="no_active">
                        <a href="{{ $url }}" class="no_active_a">{{ $page }}</a>
                    </div>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- 最後のページへ移動 --}}
    @if ($paginator->lastPage() - $paginator->currentPage() > 2)
        <div class="no_active">
            <a href="{{ $paginator->url($paginator->lastPage()) }}"> > </a>
        </div>
    @endif
</div>

<style>
.on_active {
    width: 30px;
    height: 30px;
    color: white;
    border: 0.5px solid #337AB7;
    background-color: #337AB7;
}
.on_active_a {
    width: 30px;
    height: 30px;
    padding: 11px;
    position: relative;
    top: 3px;
}
.no_active {
    width: 30px;
    height: 30px;
    padding: auto;
    border: 0.5px solid #337AB7;
}
.no_active_a {
    width: 30px;
    height: 30px;
    padding: 11px;
    color: #666;
    position: relative;
    top: 3px;
}
</style>