@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $paginator->onFirstPage() }}" style="color:green">
                &laquo;
            </a>
        </li>

        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}" >
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-disabled="{{ !$paginator->hasMorePages() }}" style="color:#E89F71">
                &raquo; 
            </a>
        </li>
    </ul>
</nav>
@endif
