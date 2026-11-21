<?php

namespace Tests\Unit;

use App\Content\Language;
use App\Content\Lesson;
use App\Content\Level;
use App\Content\Question;
use App\Content\QuestionType;
use App\Progress\LearnerProgress;
use PHPUnit\Framework\TestCase;

class LearnerProgressTest extends TestCase
{
    public function test_steps_open_one_at_a_time_in_order(): void
    {
        $this->assertSame(['l1-a'], $this->openSteps());
        $this->assertSame(['l1-a', 'l1-b'], $this->openSteps(['python-l1-a']));
        $this->assertSame(['l1-a', 'l1-b', 'l1-practice'], $this->openSteps(['python-l1-a', 'python-l1-b']));
        $this->assertSame(['l1-a', 'l1-b', 'l1-practice', 'l2-a'], $this->openSteps(['python-l1-a', 'python-l1-b'], ['python-l1']));
    }

    public function test_the_next_level_stays_locked_until_the_practice_is_passed(): void
    {
        [$level1, $level2] = $this->language()->levels;
        $progress = new LearnerProgress($this->language(), ['python-l1-a', 'python-l1-b', 'python-l2-a']);

        $this->assertTrue($progress->isPracticeOpen($level1));
        $this->assertFalse($progress->isPracticeDone($level1));
        // Finished before, so it stays open for review.
        $this->assertTrue($progress->isLessonOpen($level2->lessons[0]));
        $this->assertFalse($progress->isLessonOpen($level2->lessons[1]));
    }

    public function test_a_level_opens_with_its_first_step_and_is_done_when_all_its_steps_are(): void
    {
        [$level1, $level2] = $this->language()->levels;

        $fresh = new LearnerProgress($this->language());
        $this->assertTrue($fresh->isLevelOpen($level1));
        $this->assertFalse($fresh->isLevelOpen($level2));
        $this->assertFalse($fresh->isLevelDone($level1));

        $lessonsRead = new LearnerProgress($this->language(), ['python-l1-a', 'python-l1-b']);
        $this->assertFalse($lessonsRead->isLevelDone($level1));
        $this->assertFalse($lessonsRead->isLevelOpen($level2));

        $passed = new LearnerProgress($this->language(), ['python-l1-a', 'python-l1-b'], ['python-l1']);
        $this->assertTrue($passed->isLevelDone($level1));
        $this->assertTrue($passed->isLevelOpen($level2));
        $this->assertFalse($passed->isLevelDone($level2));
    }

    /**
     * @param  list<string>  $lessons
     * @param  list<string>  $practices
     * @return list<string>
     */
    private function openSteps(array $lessons = [], array $practices = []): array
    {
        $language = $this->language();
        $progress = new LearnerProgress($language, $lessons, $practices);
        $open = [];

        foreach ($language->levels as $level) {
            foreach ($level->lessons as $lesson) {
                if ($progress->isLessonOpen($lesson)) {
                    $open[] = substr($lesson->id, strlen('python-'));
                }
            }

            if ($progress->isPracticeOpen($level)) {
                $open[] = substr($level->id, strlen('python-')).'-practice';
            }
        }

        return $open;
    }

    private function language(): Language
    {
        return new Language('python', 'Python', 'Mudah dibaca.', 'main.py', [$this->level(1), $this->level(2)]);
    }

    private function level(int $order): Level
    {
        return new Level(
            id: "python-l{$order}",
            title: 'Dasar',
            order: $order,
            description: '',
            minScore: 70,
            lessons: [
                new Lesson("python-l{$order}-a", 'Pengenalan', 1, 20, '## Coba ini'),
                new Lesson("python-l{$order}-b", 'Variabel', 2, 20, '## Coba ini'),
            ],
            questions: [
                new Question("python-l{$order}-q1", 'python', QuestionType::PredictOutput, 'Apa outputnya?', '1', 'Karena.', 10),
            ],
        );
    }
}
