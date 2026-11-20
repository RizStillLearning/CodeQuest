<?php

namespace App\Content;

final readonly class Lesson
{
    public function __construct(
        public string $id,
        public string $title,
        public int $order,
        public int $xp,
    ) {}
}
