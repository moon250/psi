<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

abstract class FileStorageService
{
    protected string $fileName;

    public function add(string $data): void
    {
        $fileContent = $this->getData();

        if (!in_array($data, $fileContent, true)) {
            $fileContent[] = $data;
            Storage::put($this->fileName, serialize($fileContent));
        }
    }

    public function remove(string $data): void
    {
        $fileContent = $this->getData();

        if (in_array($data, $fileContent, true)) {
            $fileContent = array_diff($fileContent, [$data]);
            Storage::put($this->fileName, serialize($fileContent));
        }
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->getData();
    }

    public function exists(string $content): bool
    {
        $fileContent = $this->getData();

        return in_array($content, $fileContent, true);
    }

    /**
     * @return string[]
     */
    private function getData(): array
    {
        $this->checkFile();

        /** @var string $fileContent */
        $fileContent = Storage::get($this->fileName);

        return unserialize($fileContent);
    }

    private function checkFile(): void
    {
        if (Storage::missing($this->fileName)) {
            Storage::put($this->fileName, serialize([]));
        }
    }
}
