<?php

namespace Tests\Feature;

use App\Models\Completion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Progress is saved per learner and unlocks the path in order: opening a lesson
 * completes it, and passing a level's practice completes it and opens the next
 * level. Uses the real content/.
 */
class ProgressTest extends TestCase
{
    use RefreshDatabase;

    private const LOCKED_MESSAGE = 'Materi itu masih terkunci. Selesaikan langkah sebelumnya dulu, ya.';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_opening_a_lesson_completes_it_once(): void
    {
        $this->get('/belajar/python/1/pelajaran/1')->assertOk();
        $this->get('/belajar/python/1/pelajaran/1')->assertOk();

        $this->assertDatabaseCount('completions', 1);
        $this->assertDatabaseHas('completions', [
            'user_id' => $this->user->id,
            'type' => Completion::LESSON,
            'content_id' => 'python-l1-introduction',
        ]);
    }

    public function test_level_page_marks_visited_lessons_done_points_at_the_next_step_and_locks_the_rest(): void
    {
        $this->get('/belajar/python/1/pelajaran/1');

        $this->get('/belajar/python/1')
            ->assertOk()
            ->assertSeeInOrder(['is-lesson is-open is-done', '(selesai)', 'Pengenalan Pemrograman'], false)
            ->assertSeeInOrder(['is-lesson is-open is-current', 'Lanjutkan', 'Variabel'], false)
            ->assertSeeInOrder(['is-lesson is-locked', '(terkunci)', 'Tipe Data'], false)
            ->assertSee('1 dari 4 langkah selesai')
            ->assertSee('Lanjutkan Level 1')
            ->assertSee('class="is-progress"', false);
    }

    public function test_a_locked_lesson_sends_the_learner_back_to_the_path(): void
    {
        $this->get('/belajar/python/1/pelajaran/2')
            ->assertRedirect(url('/belajar/python'))
            ->assertSessionHas('status', self::LOCKED_MESSAGE);

        $this->assertDatabaseCount('completions', 0);
    }

    public function test_practice_is_locked_until_every_lesson_of_the_level_is_read(): void
    {
        $this->get('/belajar/python/1/pelajaran/1');

        $this->get('/belajar/python/1/latihan/1')->assertRedirect(url('/belajar/python'));
        $this->post('/belajar/python/1/latihan/1', ['answer' => 'x'])->assertRedirect(url('/belajar/python'));
        $this->get('/belajar/python/1/latihan/hasil')->assertRedirect(url('/belajar/python'));
        $this->post('/belajar/python/1/latihan/ulangi')->assertRedirect(url('/belajar/python'));
        $this->assertDatabaseCount('answers', 0);

        $this->readLessons('python', 1);

        $this->get('/belajar/python/1/latihan/1')->assertOk();
    }

    public function test_passing_the_practice_completes_it_and_unlocks_the_next_level(): void
    {
        $this->readLessons('python', 1);
        $this->get('/belajar/python/2/pelajaran/1')->assertRedirect(url('/belajar/python'));

        $this->answerQuestions('python', 1);

        $this->assertDatabaseHas('completions', [
            'user_id' => $this->user->id,
            'type' => Completion::PRACTICE,
            'content_id' => 'python-l1',
        ]);
        $this->get('/belajar/python/1')
            ->assertSeeInOrder(['is-practice is-open is-done', '(selesai)', '10 soal latihan'], false);
        $this->get('/belajar/python/2')->assertOk();
        $this->get('/belajar/python/2/pelajaran/1')->assertOk();
    }

    public function test_practice_below_the_minimum_score_keeps_the_next_level_locked(): void
    {
        $this->readLessons('python', 1);

        // Python level 1 needs 70%: 7 of its 10 questions.
        $this->answerQuestions('python', 1, correct: 6);

        $this->assertDatabaseMissing('completions', ['type' => Completion::PRACTICE]);
        $this->get('/belajar/python/1')
            ->assertSeeInOrder(['is-practice is-open is-current', '10 soal latihan'], false);
        $this->get('/belajar/python')->assertSee('Level 2 terkunci');
        $this->get('/belajar/python/2')->assertRedirect(url('/belajar/python'));
        $this->get('/belajar/python/2/pelajaran/1')->assertRedirect(url('/belajar/python'));

        $this->post('/belajar/python/1/latihan/ulangi');
        $this->answerQuestions('python', 1, correct: 7);

        $this->assertDatabaseHas('completions', ['type' => Completion::PRACTICE, 'content_id' => 'python-l1']);
        $this->get('/belajar/python/2/pelajaran/1')->assertOk();
    }

    public function test_practice_is_not_complete_until_every_question_is_answered(): void
    {
        $this->readLessons('python', 1);

        $this->post('/belajar/python/1/latihan/4', ['answer' => '65']);

        $this->assertDatabaseMissing('completions', ['type' => Completion::PRACTICE]);
    }

    public function test_retrying_practice_keeps_it_completed(): void
    {
        $this->readLessons('python', 1);
        $this->answerQuestions('python', 1);

        $this->post('/belajar/python/1/latihan/ulangi');

        $this->assertDatabaseCount('answers', 0);
        $this->assertDatabaseHas('completions', ['type' => Completion::PRACTICE, 'content_id' => 'python-l1']);
        $this->get('/belajar/python/2/pelajaran/1')->assertOk();
    }

    public function test_finishing_a_level_marks_it_done_and_moves_on_to_the_next(): void
    {
        $this->readLessons('python', 1);
        $this->answerQuestions('python', 1);

        $this->get('/belajar/python')
            ->assertSee('Level selesai')
            ->assertSee('Ulangi Level 1')
            ->assertSeeInOrder(['is-level is-open is-done', '(selesai)', 'Dasar Pemrograman'], false)
            ->assertSeeInOrder(['is-level is-open is-current', 'Lanjutkan', 'Sintaks Dasar'], false)
            ->assertSee('href="'.url('/belajar/python/2').'" class="btn w-100 btn-primary"', false);

        $this->get('/belajar/python/2')
            ->assertSeeInOrder(['is-lesson is-open is-current', 'Mulai di sini', 'Operator'], false);
    }

    public function test_progress_belongs_to_each_learner(): void
    {
        $this->readLessons('python', 1);
        $this->post('/belajar/python/1/latihan/4', ['answer' => '65']);

        $this->actingAs(User::factory()->create());

        $this->get('/belajar/python/1')
            ->assertDontSee('cq-path-step is-lesson is-open is-done', false)
            ->assertSee('Mulai di sini');
        $this->get('/belajar/python/1/latihan/4')->assertRedirect(url('/belajar/python'));
    }
}
