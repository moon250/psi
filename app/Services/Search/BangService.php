<?php

namespace App\Services\Search;

use Illuminate\Http\RedirectResponse;

class BangService
{
    /**
     * @var string[]
     */
    private array $redirectBangs = [
        '!g' => 'https://google.com/search?q=%s',
        '!gh' => 'https://github.com/search?q=%s',
        '!tr' => 'https://deepl.com/fr/translator#en/fr/%s',
        '!deepl' => 'https://deepl.com/fr/translator#en/fr/%s',
        '!img' => 'https://duckduckgo.com/?q=%s&iax=images&ia=images',
        '!gi' => 'https://google.com/search?q=%s&udm=2',
    ];

    public function hasBang(string $query): string|false
    {
        foreach (array_keys($this->redirectBangs) as $bang) {
            if (str_contains($query, $bang)) {
                return $bang;
            }
        }

        return false;
    }

    /**
     * Triggers the bang in the query. Assumes that the query effectively contains a bang.
     */
    public function fireBang(string $query, string $bang): RedirectResponse
    {
        $query = str_replace($bang, '', $query);

        return new RedirectResponse(
            url: sprintf($this->redirectBangs[$bang], $query)
        );
    }
}
