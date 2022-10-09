@php use Illuminate\Contracts\Pagination\LengthAwarePaginator; @endphp
@php
    /** @var LengthAwarePaginator $paginator */
@endphp
@if($paginator->lastPage() > 1)
    <ul class="pagination">
        <a href="{{ $paginator->url(1) }}">
            <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                First
            </li>
        </a>
        @for($i = 1; $i <= $paginator->lastPage(); $i++)
            @php
                $half_total_links = floor(5 / 2);
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                    $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
            @endphp
            @if($from < $i && $i < $to)
                <a href="{{ $paginator->url($i) }}">
                    <li class="{{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
                        {{ $i }}
                    </li>
                </a>
            @endif
        @endfor
        <a href="{{ $paginator->url($paginator->lastPage()) }}">
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                Last
            </li>
        </a>
    </ul>
@endif
