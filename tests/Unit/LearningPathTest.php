<?php

namespace Tests\Unit;

use App\Content\Language;
use App\Content\Lesson;
use App\Content\Level;
use App\Content\Question;
use App\Content\QuestionType;
use App\Content\Track;
use App\ViewModels\LearningPath;
use PHPUnit\Framework\TestCase;

class LearningPathTest extends TestCase
{
    public function test_steps_are_lessons_then_practice_then_next_level(): void
    {
        $path = new LearningPath($this->level(), $this->level(order: 2, title: 'Percabangan'));

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
        $path = new LearningPath($this->level());

        $this->assertSame('Segera hadir', end($path->steps)['title']);
        $this->assertSame('Level 2', end($path->steps)['kind']);
    }

    public function test_for_tracks_builds_one_path_per_language(): void
    {
        $language = new Language('python', 'Python', '', 'main.py', [$this->level()]);
        $paths = LearningPath::forTracks([Track::fromLanguage($language)]);

        $this->assertSame(['python'], array_keys($paths));
        $this->assertSame('Pengenalan', $paths['python']->steps[0]['title']);
    }

    public function test_line_passes_through_every_node_center(): void
    {
        $path = new LearningPath($this->level());

        // Nodes at x = 0, 18, 36, 18 (% of width) and y = 50, 150, 250, 350.
        $this->assertSame(
            'M 0 50 C 0 100, 18 100, 18 150 C 18 200, 36 200, 36 250 C 36 300, 18 300, 18 350',
            $path->line,
        );
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
