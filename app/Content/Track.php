<?php

namespace App\Content;

/**
 * One language's learning path as shown in the language tabs: the level to
 * show and the level that comes after it.
 */
final readonly class Track
{
    public function __construct(
        public Language $language,
        public Level $level,
        public ?Level $nextLevel,
    ) {}

    /**
     * Starts at the first level. Once progress tracking exists, the level
     * shown will be the learner's current one.
     */
    public static function fromLanguage(Language $language): self
    {
        $level = $language->firstLevel();

        return new self($language, $level, $language->levelAfter($level));
    }
}
