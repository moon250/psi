<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class BlacklistService
{
    public function add(string $website): void
    {
        $blacklist = $this->getBlacklist();

        if (!in_array($website, $blacklist, true)) {
            $blacklist[] = $website;
            Storage::put('blacklist', serialize($blacklist));
        }
    }

    public function remove(string $website): void
    {
        $blacklist = $this->getBlacklist();

        if (in_array($website, $blacklist, true)) {
            $blacklist = array_diff($blacklist, [$website]);
            Storage::put('blacklist', serialize($blacklist));
        }
    }

    public function exists(string $website): bool
    {
        $blacklist = $this->getBlacklist();

        return in_array($website, $blacklist, true);
    }

    /**
     * @return string[]
     */
    private function getBlacklist(): array
    {
        $this->checkFile();

        /** @var string $blacklist */
        $blacklist = Storage::get('blacklist');

        return unserialize($blacklist);
    }

    private function checkFile(): void
    {
        if (Storage::missing('blacklist')) {
            Storage::put('blacklist', serialize([]));
        }
    }
}
