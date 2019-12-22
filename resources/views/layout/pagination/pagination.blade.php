{{-- 件数表示（ユーザー側で使用）--}}
<div class="top_pagination">
    <div id="from_to_count" style="margin-bottom: -10px;">
        <p class="right pa_lr4" style="">{{ $paginator->firstItem() }}～{{ $paginator->lastItem() }}表示&nbsp;/&nbsp;{{ $paginator->total() }}件中</p>
    </div>
    {{-- 前へ、次へ --}}
    @if ($paginator->lastPage() > 1)
    <div class="pagination" style="font-size: large; width: 100%; margin-bottom: 10px;">
        @if ($paginator->currentPage() != 1 && $paginator->lastPage() >= 5)
            <span style="display: inline-block; text-align: center; border: 1px solid #333333;">
                <a href="{{ $paginator->url($paginator->url(1)) }}" style="text-decoration: none; padding: 10px; color: black;">
                  «
                </a>
            </span>
        @endif

        @if($paginator->currentPage() != 1)
            <span style="display: inline-block; text-align: center; margin-left: 5px; border: 1px solid #333333;">
                <a href="{{ $paginator->url($paginator->currentPage()-1) }}" style="text-decoration: none; padding: 10px; color: black;">
                    <
                </a>
            </span>
        @endif

        @for($i = max($paginator->currentPage()-1, 1); $i <= min(max($paginator->currentPage()-1, 1)+2,$paginator->lastPage()); $i++)
            <span class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}" style="display: inline-block; text-align: center; margin-left: 5px; border: 1px solid #333333;">
                <a href="{{ $paginator->url($i) }}" style="text-decoration: none; padding: 10px; color: black;">
                    {{ $i }}
                </a>
            </span>
        @endfor

        @if ($paginator->currentPage() != $paginator->lastPage())
            <span style="display: inline-block; text-align: center; margin-left: 5px; border: 1px solid #333333;">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}" style="text-decoration: none; padding: 10px; color: black;">
                    >
                </a>
            </span>
        @endif

        @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= 5)
            <span style="display: inline-block; text-align: center; margin-left: 5px; border: 1px solid #333333;">
                <a href="{{ $paginator->url($paginator->lastPage()) }}" style="text-decoration: none; padding: 10px; color: black;">
                   »
                </a>
            </span>
        @endif
    </div>
    @elseif ($paginator->lastPage() == 1)
        <span class="active" style="display: inline-block; text-align: center; margin-left: 5px; border: 1px solid #333333;">
                <a style="text-decoration: none; padding: 10px; color: black;">
                    1
                </a>
        </span>
    @endif
</div>

<style>
.active {
    font-weight: bold;
}
</style>