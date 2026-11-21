<?php

namespace Tests\Feature;

use App\Content\ContentRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uses the real Python questions in content/python/. Level 1's lessons are read
 * first, since its practice is locked until then.
 */
class PracticeTest extends TestCase
{
    use RefreshDatabase;

    private const MULTIPLE_CHOICE_ANSWER = 'Dari atas ke bawah, satu baris setiap kali';

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->actingAs(User::factory()->create());
        $this->readLessons('python', 1);
    }

    public function test_guests_are_sent_to_login(): void
    {
        auth()->forgetUser();

        $this->get('/belajar/python/1/latihan/1')->assertRedirect(route('login'));
    }

    public function test_question_page_shows_the_question_and_a_form(): void
    {
        $this->get('/belajar/python/1/latihan/1')
            ->assertOk()
            ->assertSee('Soal 1 dari 10')
            ->assertSee('Dalam urutan apa Python menjalankan baris-baris program?')
            ->assertSee('type="radio"', false)
            ->assertSee('Cek jawaban');
    }

    public function test_correct_answer_shows_feedback_with_the_explanation(): void
    {
        $this->post('/belajar/python/1/latihan/1', ['answer' => self::MULTIPLE_CHOICE_ANSWER])
            ->assertRedirect(url('/belajar/python/1/latihan/1'));

        $this->get('/belajar/python/1/latihan/1')
            ->assertSee('Tepat sekali!')
            ->assertSee('Python mulai dari baris pertama')
            ->assertSee('Soal berikutnya')
            ->assertDontSee('Cek jawaban');
    }

    public function test_wrong_text_answer_shows_the_correct_answer(): void
    {
        $this->post('/belajar/python/1/latihan/4', ['answer' => '50']);

        $this->get('/belajar/python/1/latihan/4')
            ->assertSee('Belum tepat.')
            ->assertSee('Jawaban yang benar')
            ->assertSee('65');
    }

    public function test_multiline_output_is_accepted_with_windows_line_endings(): void
    {
        $this->post('/belajar/python/1/latihan/2', ['answer' => "Halo\r\nCodeQuest"]);

        $this->get('/belajar/python/1/latihan/2')->assertSee('Tepat sekali!');
    }

    public function test_answer_is_saved_as_soon_as_it_is_given(): void
    {
        $this->post('/belajar/python/1/latihan/4', ['answer' => '65']);

        $this->assertDatabaseHas('answers', [
            'user_id' => auth()->id(),
            'question_id' => 'python-l1-q04',
            'answer' => '65',
            'correct' => true,
        ]);
    }

    public function test_empty_answer_is_rejected_with_an_indonesian_message(): void
    {
        $this->from('/belajar/python/1/latihan/4')->post('/belajar/python/1/latihan/4', ['answer' => '   '])
            ->assertRedirect('/belajar/python/1/latihan/4')
            ->assertSessionHasErrors(['answer' => 'Jawaban wajib diisi.']);

        $this->assertDatabaseMissing('answers', ['question_id' => 'python-l1-q04']);
    }

    public function test_option_answer_must_be_one_of_the_options(): void
    {
        $this->post('/belajar/python/1/latihan/1', ['answer' => 'Jawaban karangan'])
            ->assertSessionHasErrors(['answer' => 'Jawaban yang dipilih tidak valid.']);
    }

    public function test_first_answer_counts(): void
    {
        $this->post('/belajar/python/1/latihan/4', ['answer' => '50']);
        $this->post('/belajar/python/1/latihan/4', ['answer' => '65']);

        $this->assertDatabaseCount('answers', 1);
        $this->assertDatabaseHas('answers', ['question_id' => 'python-l1-q04', 'answer' => '50', 'correct' => false]);
    }

    public function test_last_question_leads_to_the_results(): void
    {
        $this->post('/belajar/python/1/latihan/10', ['answer' => 'print(int(score) + 10)']);

        $this->get('/belajar/python/1/latihan/10')
            ->assertSee('Lihat hasil')
            ->assertSee(url('/belajar/python/1/latihan/hasil'));
    }

    public function test_results_count_correct_wrong_and_unanswered_questions(): void
    {
        $this->post('/belajar/python/1/latihan/1', ['answer' => self::MULTIPLE_CHOICE_ANSWER]);
        $this->post('/belajar/python/1/latihan/4', ['answer' => '50']);

        $this->get('/belajar/python/1/latihan/hasil')
            ->assertOk()
            ->assertSee('1 dari 10 soal benar')
            ->assertSee('Masih ada 8 soal yang belum kamu jawab.')
            ->assertSeeInOrder(['Soal 1', 'Benar', 'Soal 2', 'Belum dijawab', 'Soal 4', 'Salah']);
    }

    public function test_passed_results_lead_to_the_next_level_or_back_to_the_path_after_the_last_one(): void
    {
        $this->answerQuestions('python', 1);

        $this->get('/belajar/python/1/latihan/hasil')
            ->assertSee('Sempurna! Semua jawabanmu benar.')
            ->assertSee('Lanjut ke Level 2')
            ->assertSee('href="'.url('/belajar/python/2').'"', false)
            ->assertSee('href="'.url('/belajar/python').'"', false);

        $levels = app(ContentRepository::class)->languages()['python']->levels;

        foreach (array_slice($levels, 1) as $level) {
            $this->readLessons('python', $level->order);
            $this->answerQuestions('python', $level->order);
        }

        // The last level has no next one.
        $this->get('/belajar/python/'.end($levels)->order.'/latihan/hasil')
            ->assertDontSee('Lanjut ke Level')
            ->assertSee('Kembali ke jalur belajar');
    }

    public function test_question_shows_what_the_user_types_when_the_code_reads_input(): void
    {
        $this->answerQuestions('python', 1);
        $this->readLessons('python', 2);
        $this->answerQuestions('python', 2);
        $this->readLessons('python', 3);

        $this->get('/belajar/python/3/latihan/2')
            ->assertOk()
            ->assertSeeInOrder(['number = int(input())', 'Input pengguna', '<kbd class="cq-code-input-value">7</kbd>'], false);
    }

    public function test_results_at_the_minimum_score_pass(): void
    {
        $this->answerQuestions('python', 1, correct: 7);

        $this->get('/belajar/python/1/latihan/hasil')
            ->assertSee('7 dari 10 soal benar')
            ->assertSee('Latihan selesai!')
            ->assertSee('Lanjut ke Level 2');
    }

    public function test_results_below_the_minimum_score_ask_for_a_retry(): void
    {
        $this->answerQuestions('python', 1, correct: 6);

        $this->get('/belajar/python/1/latihan/hasil')
            ->assertSee('6 dari 10 soal benar')
            ->assertSee('Kamu butuh minimal 7 jawaban benar (70%) untuk menyelesaikan latihan ini.')
            ->assertSeeInOrder(['class="btn btn-primary"', 'Ulangi latihan'], false)
            ->assertDontSee('Lanjut ke Level');
    }

    public function test_results_without_answers_invite_to_start(): void
    {
        $this->get('/belajar/python/1/latihan/hasil')
            ->assertOk()
            ->assertSee('Belum ada soal yang dijawab')
            ->assertSee(url('/belajar/python/1/latihan/1'));
    }

    public function test_restart_clears_the_answers(): void
    {
        $this->post('/belajar/python/1/latihan/1', ['answer' => self::MULTIPLE_CHOICE_ANSWER]);

        $this->post('/belajar/python/1/latihan/ulangi')->assertRedirect(url('/belajar/python/1/latihan/1'));

        $this->assertDatabaseMissing('answers', ['question_id' => 'python-l1-q01']);
        $this->get('/belajar/python/1/latihan/1')->assertSee('Cek jawaban');
    }

    public function test_question_number_outside_the_level_is_not_found(): void
    {
        $this->get('/belajar/python/1/latihan/0')->assertNotFound();
        $this->get('/belajar/python/1/latihan/11')->assertNotFound();
        $this->post('/belajar/python/1/latihan/11', ['answer' => 'x'])->assertNotFound();
    }

    public function test_every_language_has_playable_practice(): void
    {
        foreach (['python', 'java', 'c'] as $language) {
            $this->readLessons($language, 1);
            $this->get("/belajar/{$language}/1/latihan/1")->assertOk()->assertSee('Soal 1 dari 10');
        }
    }
}
