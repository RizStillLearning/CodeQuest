<?php

namespace Tests\Unit;

use App\Content\Language;
use App\Content\Lesson;
use App\Content\Level;
use App\Content\Question;
use App\Content\QuestionType;
use App\Progress\LearnerProgress;
use App\ViewModels\LearningPath;
use Tests\TestCase;

class LearningPathTest extends TestCase
{
    public function test_language_path_has_a_node_per_level_and_ends_with_coming_soon(): void
    {
        $path = $this->languagePath([$this->level(1, 'Dasar'), $this->level(2, 'Sintaks')]);

        $this->assertSame(['level', 'level', 'soon'], array_column($path->steps, 'type'));
        $this->assertSame(['Level 1', 'Level 2', 'Level 3'], array_column($path->steps, 'kind'));
        $this->assertSame(['Dasar', 'Sintaks', 'Segera hadir'], array_column($path->steps, 'title'));
        $this->assertSame('2 pelajaran · 2 soal · 55 XP', $path->steps[0]['meta']);
    }

    public function test_without_progress_only_the_first_level_is_open(): void
    {
        $path = $this->languagePath([$this->level(1), $this->level(2)]);

        $this->assertSame([url('/belajar/python/1'), null, null], array_column($path->steps, 'url'));
        $this->assertSame([false, true, true], array_column($path->steps, 'locked'));
        $this->assertSame([true, false, false], array_column($path->steps, 'current'));
        $this->assertSame(['play', 'flag', 'lock'], array_column($path->steps, 'icon'));
        $this->assertSame('Mulai di sini', $path->steps[0]['badge']);
    }

    public function test_a_level_in_progress_is_where_to_continue(): void
    {
        $path = $this->languagePath([$this->level(1), $this->level(2)], lessons: ['python-l1-a']);

        $this->assertTrue($path->steps[0]['current']);
        $this->assertSame('Lanjutkan', $path->steps[0]['badge']);
        $this->assertTrue($path->steps[1]['locked']);
    }

    public function test_a_finished_level_is_done_and_opens_the_next_one(): void
    {
        $path = $this->languagePath(
            [$this->level(1), $this->level(2)],
            lessons: ['python-l1-a', 'python-l1-b'],
            practices: ['python-l1'],
        );

        $this->assertTrue($path->steps[0]['done']);
        $this->assertSame('trophy', $path->steps[0]['icon']);
        $this->assertSame(url('/belajar/python/1'), $path->steps[0]['url']);
        $this->assertTrue($path->steps[1]['current']);
        $this->assertSame(url('/belajar/python/2'), $path->steps[1]['url']);
        $this->assertSame('M 0 50 C 0 100, 18 100, 18 150', $path->progressLine);
    }

    public function test_language_level_buttons_go_to_the_level_pages(): void
    {
        $path = $this->languagePath(
            [$this->level(1), $this->level(2), $this->level(3)],
            lessons: ['python-l1-a', 'python-l1-b', 'python-l2-a'],
            practices: ['python-l1'],
        );

        $this->assertSame([
            'done' => 3, 'total' => 3, 'percent' => 100, 'finished' => true,
            'url' => url('/belajar/python/1'), 'action' => 'Ulangi', 'locked' => false, 'next' => false,
        ], $path->levelProgress['python-l1']);

        $this->assertSame([
            'done' => 1, 'total' => 3, 'percent' => 33, 'finished' => false,
            'url' => url('/belajar/python/2'), 'action' => 'Lanjutkan', 'locked' => false, 'next' => true,
        ], $path->levelProgress['python-l2']);

        $this->assertSame([
            'done' => 0, 'total' => 3, 'percent' => 0, 'finished' => false,
            'url' => null, 'action' => 'Mulai', 'locked' => true, 'next' => false,
        ], $path->levelProgress['python-l3']);
    }

    public function test_level_path_has_its_flag_lessons_practice_and_the_next_level(): void
    {
        $language = $this->language([$this->level(1, 'Dasar'), $this->level(2, 'Sintaks')]);
        [$first, $last] = $language->levels;

        $path = $this->levelPath($language, $first);

        $this->assertSame(['level', 'lesson', 'lesson', 'practice', 'level'], array_column($path->steps, 'type'));
        $this->assertSame(['Dasar', 'Pengenalan', 'Variabel', '2 soal latihan', 'Sintaks'], array_column($path->steps, 'title'));
        $this->assertSame('+15 XP · 2 jenis soal', $path->steps[3]['meta']);
        $this->assertSame([$first], $path->levels);

        $lastSteps = $this->levelPath($language, $last)->steps;
        $this->assertSame('soon', end($lastSteps)['type']);
    }

    public function test_without_progress_only_the_first_lesson_is_open(): void
    {
        $language = $this->language([$this->level(1), $this->level(2)]);
        $path = $this->levelPath($language, $language->levels[0]);

        $this->assertSame([null, url('/belajar/python/1/pelajaran/1'), null, null, null], array_column($path->steps, 'url'));
        $this->assertSame([false, false, true, true, true], array_column($path->steps, 'locked'));
        $this->assertSame(['flag', 'play', 'lock', 'lock', 'flag'], array_column($path->steps, 'icon'));
        $this->assertSame('Mulai di sini', $path->steps[1]['badge']);
        $this->assertSame([], array_keys(array_filter(array_column($path->steps, 'done'))));
        $this->assertSame('', $path->progressLine);
    }

    public function test_finished_steps_are_done_and_the_first_unfinished_one_is_current(): void
    {
        $language = $this->language([$this->level(1), $this->level(2)]);
        $path = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a']);

        $this->assertTrue($path->steps[1]['done']);
        $this->assertSame('check', $path->steps[1]['icon']);
        $this->assertNull($path->steps[1]['badge']);

        $this->assertTrue($path->steps[2]['current']);
        $this->assertSame('Lanjutkan', $path->steps[2]['badge']);
        $this->assertSame('play', $path->steps[2]['icon']);

        $this->assertTrue($path->steps[3]['locked']);
        $this->assertNull($path->steps[3]['url']);
    }

    public function test_a_finished_step_after_the_current_one_stays_open(): void
    {
        // Possible when content gains a lesson before ones the learner already finished.
        $language = $this->language([$this->level(1), $this->level(2)]);
        $path = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-b']);

        $this->assertTrue($path->steps[1]['current']);
        $this->assertTrue($path->steps[2]['done']);
        $this->assertSame(url('/belajar/python/1/pelajaran/2'), $path->steps[2]['url']);
        $this->assertTrue($path->steps[3]['locked']);
    }

    public function test_a_finished_level_leads_on_to_the_next_one(): void
    {
        $language = $this->language([$this->level(1), $this->level(2)]);
        $path = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a', 'python-l1-b'], practices: ['python-l1']);

        $this->assertTrue($path->steps[0]['done']);
        $this->assertSame('trophy', $path->steps[0]['icon']);
        $this->assertTrue($path->steps[4]['current']);
        $this->assertSame(url('/belajar/python/2'), $path->steps[4]['url']);
        $this->assertSame('Lanjutkan', $path->steps[4]['badge']);
    }

    public function test_level_button_goes_to_the_step_to_continue_with(): void
    {
        $language = $this->language([$this->level(1), $this->level(2)]);

        $this->assertSame([
            'done' => 1, 'total' => 3, 'percent' => 33, 'finished' => false,
            'url' => url('/belajar/python/1/pelajaran/2'), 'action' => 'Lanjutkan', 'locked' => false, 'next' => true,
        ], $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a'])->levelProgress['python-l1']);

        $finished = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a', 'python-l1-b'], practices: ['python-l1']);
        $this->assertSame(url('/belajar/python/1/pelajaran/1'), $finished->levelProgress['python-l1']['url']);
        $this->assertSame('Ulangi', $finished->levelProgress['python-l1']['action']);
    }

    public function test_progress_line_runs_from_the_start_to_the_current_step(): void
    {
        $language = $this->language();
        $path = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a']);

        // Through the flag (0), the done lesson (1), and the current lesson (2).
        $this->assertSame('M 0 50 C 0 100, 18 100, 18 150 C 18 200, 36 200, 36 250', $path->progressLine);
    }

    public function test_when_everything_is_done_there_is_no_current_step(): void
    {
        $language = $this->language();
        $path = $this->levelPath($language, $language->levels[0], lessons: ['python-l1-a', 'python-l1-b'], practices: ['python-l1']);

        $this->assertNotContains(true, array_column($path->steps, 'current'));
        $this->assertSame('M 0 50 C 0 100, 18 100, 18 150 C 18 200, 36 200, 36 250 C 36 300, 18 300, 18 350', $path->progressLine);
    }

    public function test_preview_shows_the_first_level_as_a_new_learner_sees_it(): void
    {
        $path = LearningPath::preview($this->language([$this->level(1, 'Dasar'), $this->level(2, 'Sintaks')]));

        $this->assertSame(['level', 'lesson', 'lesson', 'practice', 'level'], array_column($path->steps, 'type'));
        $this->assertSame('Sintaks', end($path->steps)['title']);
        $this->assertTrue(end($path->steps)['locked']);
        $this->assertSame('Mulai di sini', $path->steps[1]['badge']);
    }

    public function test_line_passes_through_every_node_center(): void
    {
        $language = $this->language();
        $path = $this->levelPath($language, $language->levels[0]);

        // Nodes at x = 0, 18, 36, 18, 0 (% of width) and y = 50, 150, 250, 350, 450.
        $this->assertSame([0, 1, 2, 1, 0], array_column($path->steps, 'shift'));
        $this->assertSame(
            'M 0 50 C 0 100, 18 100, 18 150 C 18 200, 36 200, 36 250 C 36 300, 18 300, 18 350 C 18 400, 0 400, 0 450',
            $path->line,
        );
    }

    /**
     * @param  list<Level>  $levels
     * @param  list<string>  $lessons  completed lesson ids
     * @param  list<string>  $practices  ids of levels whose practice is passed
     */
    private function languagePath(array $levels, array $lessons = [], array $practices = []): LearningPath
    {
        $language = $this->language($levels);

        return LearningPath::forLanguage($language, new LearnerProgress($language, $lessons, $practices));
    }

    /**
     * @param  list<string>  $lessons  completed lesson ids
     * @param  list<string>  $practices  ids of levels whose practice is passed
     */
    private function levelPath(Language $language, Level $level, array $lessons = [], array $practices = []): LearningPath
    {
        return LearningPath::forLevel($language, $level, new LearnerProgress($language, $lessons, $practices));
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
                new Lesson("python-l{$order}-a", 'Pengenalan', 1, 20, '## Coba ini'),
                new Lesson("python-l{$order}-b", 'Variabel', 2, 20, '## Coba ini'),
            ],
            questions: [
                new Question("python-l{$order}-q1", 'python', QuestionType::PredictOutput, 'Apa outputnya?', '1', 'Karena.', 10),
                new Question("python-l{$order}-q2", 'python', QuestionType::MultipleChoice, 'Pilih.', 'a', 'Karena.', 5, options: ['a', 'b']),
            ],
        );
    }
}
