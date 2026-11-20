<?php

namespace Tests\Unit;

use App\Content\Language;
use App\Content\Lesson;
use App\Content\Level;
use App\Content\Question;
use App\Content\QuestionType;
use App\ViewModels\LearningPath;
use PHPUnit\Framework\TestCase;

class LearningPathTest extends TestCase
{
    public function test_steps_are_lessons_then_practice_then_next_level(): void
    {
        $path = new LearningPath($this->language(), $this->level(), $this->level(order: 2, title: 'Percabangan'));

        $this->assertSame(
            ['Pengenalan', 'Variabel', '2 soal latihan', 'Percabangan'],
            array_column($path->steps, 'title'),
        );
        $this->assertSame([true, false, false, false], array_column($path->steps, 'open'));
        $this->assertSame([0, 1, 2, 1], array_column($path->steps, 'shift'));
        $this->assertSame('+15 XP · 2 jenis soal', $path->steps[2]['meta']);
    }

    public function test_missing_next_level_shows_coming_soon(): void
    {
        $path = new LearningPath($this->language(), $this->level());

        $this->assertSame('Segera hadir', end($path->steps)['title']);
        $this->assertSame('Level 2', end($path->steps)['kind']);
    }

    public function test_for_language_starts_at_the_first_level_and_points_to_the_next(): void
    {
        $first = $this->level();
        $second = $this->level(order: 2, title: 'Percabangan');

        $path = LearningPath::forLanguage($this->language([$first, $second]));

        $this->assertSame($first, $path->level);
        $this->assertSame($second, $path->nextLevel);
        $this->assertSame('Percabangan', end($path->steps)['title']);
    }

    public function test_line_passes_through_every_node_center(): void
    {
        $path = new LearningPath($this->language(), $this->level());

        // Nodes at x = 0, 18, 36, 18 (% of width) and y = 50, 150, 250, 350.
        $this->assertSame(
            'M 0 50 C 0 100, 18 100, 18 150 C 18 200, 36 200, 36 250 C 36 300, 18 300, 18 350',
            $path->line,
        );
    }

    /**
     * @param  list<Level>|null  $levels
     */
    private function language(?array $levels = null): Language
    {
        return new Language('python', 'Python', 'Mudah dibaca.', 'main.py', $levels ?? [$this->level()]);
    }

    private function level(int $order = 1, string $title = 'Dasar Pemrograman'): Level
    {
        return new Level(
            id: "python-l{$order}",
            title: $title,
            order: $order,
            description: '',
            minScore: 70,
            lessons: [
                new Lesson('python-l1-a', 'Pengenalan', 1, 20),
                new Lesson('python-l1-b', 'Variabel', 2, 20),
            ],
            questions: [
                new Question('python-l1-q1', 'python', QuestionType::PredictOutput, 'Apa outputnya?', '1', 'Karena.', 10),
                new Question('python-l1-q2', 'python', QuestionType::MultipleChoice, 'Pilih.', 'a', 'Karena.', 5, options: ['a', 'b']),
            ],
        );
    }
}
