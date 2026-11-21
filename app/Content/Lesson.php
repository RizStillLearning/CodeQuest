<?php

namespace App\Content;

final readonly class Lesson
{
    /**
     * @param  string  $body  Markdown, without the front matter
     */
    public function __construct(
        public string $id,
        public string $title,
        public int $order,
        public int $xp,
        public string $body,
    ) {}
}
