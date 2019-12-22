<div id="pagerNum">
    {{-- 最初のページへ移動 --}}
    @if ($paginator->currentPage() > 3)
        <div><a href="{{ $paginator->url(1) }}"></a></div>
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
                    <div><span>{{ $page }}</span></div>
                @else
                    <div><a href="{{ $url }}">{{ $page }}</a></div>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- 最後のページへ移動 --}}
    @if ($paginator->lastPage() - $paginator->currentPage() > 2)
        <div><a href="{{ $paginator->url($paginator->lastPage()) }}"></a></div>
    @endif
</div>
