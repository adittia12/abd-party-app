@if ($paginator->hasPages())
    <div class="d-flex justify-content-between flex-wrap flex-sm-nowrap align-items-center">
        <div class="d-none d-sm-block">
            <p class="small text-muted">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>
        <ul class="pagination mb-0" role="navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link"
                        href="{{ $paginator->previousPageUrl() .
                            (request('q') ? '&q=' . request('q') : '') .
                            (request('filteringMonth') ? '&filteringMonth=' . request('filteringMonth') : '') .
                            (request('filterDate') ? '&filterDate=' . request('filterDate') : '') .
                            (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                        rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link">{{ $page }}</span></li>
                        @elseif (
                            $page == 1 ||
                                $page == 2 ||
                                $page == 3 ||
                                $page == 4 ||
                                $page == $paginator->lastPage() ||
                                $page == $paginator->lastPage() - 1 ||
                                $page == $paginator->lastPage() - 2 ||
                                $page == $paginator->lastPage() - 3)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url .
                                        (request('q') ? '&q=' . request('q') : '') .
                                        (request('filteringMonth') ? '&filteringMonth=' . request('filteringMonth') : '') .
                                        (request('filterDate') ? '&filterDate=' . request('filterDate') : '') .
                                        (request('per_page') ? '&per_page=' . request('per_page') : '') }}">{{ $page }}</a>
                            </li>
                        @elseif ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url .
                                        (request('q') ? '&q=' . request('q') : '') .
                                        (request('filteringMonth') ? '&filteringMonth=' . request('filteringMonth') : '') .
                                        (request('filterDate') ? '&filterDate=' . request('filterDate') : '') .
                                        (request('per_page') ? '&per_page=' . request('per_page') : '') }}">{{ $page }}</a>
                            </li>
                        @elseif ($page == 5 || $page == $paginator->lastPage() - 4)
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link"
                        href="{{ $paginator->nextPageUrl() .
                            (request('q') ? '&q=' . request('q') : '') .
                            (request('filteringMonth') ? '&filteringMonth=' . request('filteringMonth') : '') .
                            (request('filterDate') ? '&filterDate=' . request('filterDate') : '') .
                            (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                        rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </div>
@endif
