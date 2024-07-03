<?php

namespace App\Services\Search;

readonly class SearchResult
{
    public function __construct(
        private string $title,
        private string $description,
        private string $url,
        private string $path,
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

    public function getPath(): string
    {
        return $this->path;
    }
}
