<?php

namespace App\Content;

final readonly class Level
{
    /**
     * @param  int|null  $minScore  % of questions answered correctly to unlock the next level
     * @param  list<Lesson>  $lessons  sorted by order
     * @param  list<Question>  $questions  in file order
     */
    public function __construct(
        public string $id,
        public string $title,
        public int $order,
        public string $description,
        public ?int $minScore,
        public array $lessons,
        public array $questions,
    ) {}

    public function lessonXp(): int
    {
        return array_sum(array_map(fn (Lesson $lesson) => $lesson->xp, $this->lessons));
    }

    public function questionXp(): int
    {
        return array_sum(array_map(fn (Question $question) => $question->xp, $this->questions));
    }

    public function totalXp(): int
    {
        return $this->lessonXp() + $this->questionXp();
    }

    /**
     * Number of different question types used in this level.
     */
    public function questionTypeCount(): int
    {
        return count(array_unique(array_map(fn (Question $question) => $question->type->value, $this->questions)));
    }
}
