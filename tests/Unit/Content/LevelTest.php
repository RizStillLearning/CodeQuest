<?php

namespace Tests\Unit\Content;

use App\Content\Level;
use App\Content\Question;
use App\Content\QuestionType;
use PHPUnit\Framework\TestCase;

class LevelTest extends TestCase
{
    public function test_required_correct_answers_are_the_minimum_score_rounded_up(): void
    {
        $this->assertSame(7, $this->level(minScore: 70, questions: 10)->requiredCorrect());
        $this->assertSame(5, $this->level(minScore: 70, questions: 7)->requiredCorrect());
        $this->assertSame(10, $this->level(minScore: 100, questions: 10)->requiredCorrect());
        $this->assertSame(0, $this->level(minScore: 0, questions: 10)->requiredCorrect());
    }

    private function level(int $minScore, int $questions): Level
    {
        return new Level(
            id: 'python-l1',
            title: 'Dasar',
            order: 1,
            description: '',
            minScore: $minScore,
            lessons: [],
            questions: array_map(
                fn (int $n) => new Question("python-l1-q{$n}", 'python', QuestionType::PredictOutput, 'Apa outputnya?', '1', 'Karena.', 10),
                range(1, $questions),
            ),
        );
    }
}
