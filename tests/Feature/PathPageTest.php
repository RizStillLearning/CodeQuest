<?php

namespace Tests\Feature;

use App\Content\ContentRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PathPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/belajar/python')->assertRedirect(route('login'));
    }

    public function test_a_new_learners_path_shows_only_levels_with_the_first_one_open(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['python' => 'Python', 'java' => 'Java', 'c' => 'C'] as $key => $name) {
            $levelCount = count(app(ContentRepository::class)->languages()[$key]->levels);

            $this->get("/belajar/{$key}")
                ->assertOk()
                ->assertViewIs('paths.show')
                ->assertSee('<h1 id="cq-path-title">'.$name.'</h1>', false)
                ->assertSeeInOrder([
                    'is-level is-open is-current',
                    'href="'.url("/belajar/{$key}/1").'"',
                    'Mulai di sini',
                    'Dasar Pemrograman',
                    'is-level is-locked',
                    '(terkunci)',
                    'Sintaks Dasar',
                    'is-soon is-locked',
                    'Level '.($levelCount + 1),
                ], false)
                ->assertDontSee('is-lesson', false)
                ->assertDontSee('is-practice', false)
                ->assertDontSee('href="'.url("/belajar/{$key}/2").'"', false);
        }
    }

    public function test_only_the_first_level_has_a_start_button_and_back_link_returns_to_language_choice(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/belajar/java')
            ->assertSeeInOrder([
                'href="'.url('/belajar/java/1').'" class="btn w-100 btn-primary"',
                'Mulai Level 1',
                'Level 2 terkunci',
                'Selesaikan level sebelumnya untuk membukanya.',
            ], false)
            ->assertDontSee('Mulai Level 2')
            ->assertSee('href="'.route('learn').'" class="cq-back-link"', false);
    }

    public function test_navbar_highlights_belajar_on_the_path_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/belajar/c')
            ->assertSee('class="nav-link active" href="'.route('learn').'"', false)
            ->assertDontSee('aria-current="page"', false);
    }

    public function test_unknown_language_is_not_found(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/belajar/ruby')
            ->assertNotFound();
    }
}
