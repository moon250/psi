<?php

namespace App\Services\Search;

readonly class SearchResult
{
    public function __construct(
        private string $title,
        private string $description,
        private string $url,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
