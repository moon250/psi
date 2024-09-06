<div class="search-result__wrapper" data-website="{{ $result->getWebsite() }}">
    <div class="search-result__title">
        <img src="https://icons.duckduckgo.com/ip2/{{ $result->getWebsite() }}.ico" alt="">
        <div>
            <a href="{{ $result->getUrl() }}" class="search-result__link">
                {{ $result->getTitle() }}
            </a>
            <p class="search-result__website">{{ $result->getWebsite() }}</p>
        </div>
        <svg onclick="blacklist('{{ $result->getWebsite() }}')" width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0ZM10.96 9.84C11.28 10.16 11.28 10.64 10.96 10.96C10.64 11.28 10.16 11.28 9.84 10.96L8 9.12L6.16 10.96C5.84 11.28 5.36 11.28 5.04 10.96C4.72 10.64 4.72 10.16 5.04 9.84L6.88 8L5.04 6.16C4.72 5.84 4.72 5.36 5.04 5.04C5.36 4.72 5.84 4.72 6.16 5.04L8 6.88L9.84 5.04C10.16 4.72 10.64 4.72 10.96 5.04C11.28 5.36 11.28 5.84 10.96 6.16L9.12 8L10.96 9.84Z" fill="currentColor"/>
        </svg>
    </div>
    <p>{!! $result->getDescription() !!}</p>
</div>
