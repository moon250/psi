<?php

namespace App\Services\Search;

use Illuminate\Http\RedirectResponse;

class BangService
{
    /**
     * @var string[]
     */
    private array $redirectBangs = [
        '!g' => 'https://google.com/search?q=%s', // Google search
        '!gh' => 'https://github.com/search?q=%s', // Github search

        // Deepl translation
        '!tr' => 'https://deepl.com/fr/translator#en/fr/%s',
        '!deepl' => 'https://deepl.com/fr/translator#en/fr/%s',

        '!img' => 'https://duckduckgo.com/?q=%s&iax=images&ia=images', // DDG images
        '!gi' => 'https://google.com/search?q=%s&udm=2', // Google Images
        '!yt' => 'https://youtube.com/results?search_query=%s', // Youtube

        // Google Maps
        '!gmaps' => 'https://www.google.com/maps/preview?q=%s',
        '!gm' => 'https://www.google.com/maps/preview?q=%s',
        '!meteo' => 'https://www.meteociel.fr/prevville.php?action=getville&ville=%s',

        // Reddit
        '!reddit' => 'https://www.reddit.com/search/?q=%s',
        '!r' => 'https://www.reddit.com/search?q=%s',

        // Can I use
        '!caniuse' => 'https://caniuse.com/?search=%s',
        '!ciu' => 'https://caniuse.com/?search=%s',

        '!php' => 'https://www.php.net/manual-lookup.php?pattern=%s&scope=quickref',
    ];

    public function hasBang(string $query): string|false
    {
        foreach (array_keys($this->redirectBangs) as $bang) {
            if (preg_match("/\w*{$bang} $/", $query . ' ')) {
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
        $query = trim($query);

        return new RedirectResponse(
            url: sprintf($this->redirectBangs[$bang], $query)
        );
    }
}
