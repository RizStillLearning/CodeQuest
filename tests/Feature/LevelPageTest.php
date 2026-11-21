<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * A level's own page: its lessons and practice as a path. Uses the real content/.
 */
class LevelPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->actingAs(User::factory()->create());
    }

    public function test_guests_are_sent_to_login(): void
    {
        auth()->forgetUser();

        $this->get('/belajar/python/1')->assertRedirect(route('login'));
    }

    public function test_level_page_shows_its_materials_with_only_the_first_lesson_open(): void
    {
        foreach (['python', 'java', 'c'] as $key) {
            $this->get("/belajar/{$key}/1")
                ->assertOk()
                ->assertViewIs('levels.show')
                ->assertSee('<h1 id="cq-level-title">Dasar Pemrograman</h1>', false)
                ->assertSeeInOrder([
                    'is-lesson is-open is-current',
                    'href="'.url("/belajar/{$key}/1/pelajaran/1").'"',
                    'Mulai di sini',
                    'Pengenalan Pemrograman',
                    'is-lesson is-locked',
                    '(terkunci)',
                    'is-practice is-locked',
                    '10 soal latihan',
                    'is-level is-locked',
                    'Sintaks Dasar',
                ], false)
                ->assertDontSee('href="'.url("/belajar/{$key}/1/pelajaran/2").'"', false)
                ->assertDontSee('href="'.url("/belajar/{$key}/1/latihan/1").'"', false);
        }
    }

    public function test_level_button_continues_where_the_learner_left_off(): void
    {
        $this->get('/belajar/python/1/pelajaran/1');

        $this->get('/belajar/python/1')
            ->assertSee('1 dari 4 langkah selesai')
            ->assertSeeInOrder(['href="'.url('/belajar/python/1/pelajaran/2').'" class="btn w-100 btn-primary"', 'Lanjutkan Level 1'], false)
            ->assertSee('Jawab benar minimal 7 dari 10 soal latihan untuk menyelesaikan level ini.');
    }

    public function test_a_locked_level_sends_the_learner_back_to_the_path(): void
    {
        $this->get('/belajar/python/2')
            ->assertRedirect(url('/belajar/python'))
            ->assertSessionHas('status', 'Materi itu masih terkunci. Selesaikan langkah sebelumnya dulu, ya.');
    }

    public function test_back_link_returns_to_all_levels_and_navbar_highlights_belajar(): void
    {
        $this->get('/belajar/c/1')
            ->assertSee('href="'.url('/belajar/c').'" class="cq-back-link"', false)
            ->assertSee('class="nav-link active" href="'.route('learn').'"', false);
    }

    public function test_unknown_language_or_level_is_not_found(): void
    {
        $this->get('/belajar/ruby/1')->assertNotFound();
        $this->get('/belajar/python/9')->assertNotFound();
    }
}
