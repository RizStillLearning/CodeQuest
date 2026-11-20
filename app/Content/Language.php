<?php

namespace App\Content;

final readonly class Language
{
    /**
     * @param  string  $key  folder name under content/, e.g. "python"
     * @param  string  $fileName  example file name shown above code, e.g. "main.py"
     * @param  non-empty-list<Level>  $levels  sorted by order
     */
    public function __construct(
        public string $key,
        public string $name,
        public string $tagline,
        public string $fileName,
        public array $levels,
    ) {}

    public function firstLevel(): Level
    {
        return $this->levels[0];
    }

    public function levelAfter(Level $level): ?Level
    {
        foreach ($this->levels as $candidate) {
            if ($candidate->order > $level->order) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * File extension used as the language badge, e.g. "py".
     */
    public function extension(): string
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION) ?: $this->key;
    }
}
