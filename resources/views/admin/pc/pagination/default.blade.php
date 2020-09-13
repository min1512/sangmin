@if ($paginator->lastPage() > 1)
    <div class="pagination">
        <ul class="pagination__list clb">
            <li class="pagination__item" onclick="goUrl('{{ $paginator->url(1) }}');">
                <button type="button" class="pagination__btn type-arrow type-left type-1"></button>
            </li>
            <li class="pagination__item" onclick="goUrl('{{ $paginator->url($paginator->currentPage()-1<1?1:$paginator->currentPage()-1) }}');">
                <button type="button" class="pagination__btn type-arrow type-left type-2"></button>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="pagination__item" onclick="goUrl('{{ $paginator->url($i) }}')">
                    <button type="button" class=" pagination__btn {{ ($paginator->currentPage() == $i) ? 'is-active' : '' }}">{{ $i }}</button>
                </li>
            @endfor
            <li class="pagination__item" onclick="goUrl('{{ $paginator->url($paginator->currentPage()+1>$paginator->lastPage()?$paginator->lastPage():$paginator->currentPage()+1) }}');">
                <button type="button" class="pagination__btn type-arrow type-right type-2"></button>
            </li>
            <li class="pagination__item" onclick="goUrl('{{ $paginator->url($paginator->lastPage()) }}');">
                <button type="button" class="pagination__btn type-arrow type-right type-1"></button>
            </li>
        </ul>
    </div>
@endif
