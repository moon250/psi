<?php

namespace App\Services\Search;

use Illuminate\Http\RedirectResponse;

class BangService
{
    /**
     * @var array<string, array{'url': string, 'name': string}>
     */
    private array $redirectBangs = [
        // Google search
        '!g' => [
            'name' => 'Google',
            'url' => 'https://google.com/search?q=%s'
        ],

        // Github search
        '!gh' => [
            'name' => 'Github',
            'url' => 'https://github.com/search?q=%s'
        ],

        // Deepl translation
        '!deepl' => [
            'name' => 'Deepl',
            'url' => 'https://deepl.com/fr/translator#en/fr/%s'
        ],

        // DDG images
        '!img' => [
            'name' => 'DuckDuckGo Images',
            'url' => 'https://duckduckgo.com/?q=%s&iax=images&ia=images'
        ],

        // Google Images
        '!gi' => [
            'name' => 'Google Images',
            'url' => 'https://google.com/search?q=%s&udm=2'
        ],

        // Youtube
        '!yt' => [
            'name' => 'Youtube',
            'url' => 'https://youtube.com/results?search_query=%s'
        ],

        // Google Maps
        '!gmaps' => [
            'name' => 'Google Maps',
            'url' => 'https://www.google.com/maps/preview?q=%s'
        ],

        '!meteo' => [
            'name' => 'Meteociel',
            'url' => 'https://www.meteociel.fr/prevville.php?action=getville&ville=%s',
        ],

        // Reddit
        '!reddit' => [
            'name' => 'Reddit',
            'url' => 'https://www.reddit.com/search/?q=%s',
        ],

        // Can I use
        '!caniuse' => [
            'name' => 'CanIUse',
            'url' => 'https://caniuse.com/?search=%s',
        ],

        '!php' => [
            'name' => 'PHP',
            'url' => 'https://www.php.net/manual-lookup.php?pattern=%s&scope=quickref',
        ],

        '!wiki' => [
            'name' => 'Wikipedia',
            'url' => 'https://fr.wikipedia.org/w/index.php?search=%s',
        ],
    ];

    /**
     * @var string[]
     */
    private array $bangAliases = [
        '!deepl' => '!tr',
        '!reddit' => '!r',
        '!caniuse' => '!ciu',
        '!wiki' => '!wikipedia',
    ];

    /**
     * @var string[]
     */
    public array $bangs {
        get {
            $bangList = collect($this->redirectBangs);
            $aliases = collect($this->bangAliases);
            return array_merge($bangList->keys()->all(), $aliases->values()->all());
        }
    }

    public function hasBang(string $query): string|false
    {
        foreach ($this->bangs as $bang) {
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
            url: sprintf($this->getBangs()[$bang]['url'], $query)
        );
    }

    /**
     * @return array<string, array{'url': string, 'name': string}>
     */
    public function getBangs(): array
    {
        $bangList = collect($this->redirectBangs);

        foreach ($this->bangAliases as $bang => $alias) {
            $aliasBangData = $bangList->get($bang);
            if (!$aliasBangData) continue;
            $bangList->put($alias, $aliasBangData);
        }

        return $bangList->toArray();
    }
}
