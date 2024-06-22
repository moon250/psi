@extends('template')
@section('title')Ѱ - {{ $query }}@endsection

<x-search-form :query="$query" />

<main>
    <div class="search-result__col">
        @foreach($results[0] as $result)
            <div class="search__result-wrapper">
                <a href="{{ $result->getUrl() }}">{{ $result->getTitle() }}</a>
                <p>{{ $result->getPath() }}</p>
                <p>{!! $result->getDescription() !!}</p>
            </div>
        @endforeach
    </div>
    <div class="search-result__col">
        @foreach($results[1] as $result)
            <div class="search__result-wrapper">
                <a href="{{ $result->getUrl() }}">{{ $result->getTitle() }}</a>
                <p>{!! $result->getDescription() !!}</p>
            </div>
        @endforeach
    </div>
</main>
