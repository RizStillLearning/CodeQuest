<?php

namespace Tests\Feature;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\Content\Track;
use App\Models\User;
use Tests\TestCase;

class LearnPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/belajar')->assertRedirect(route('login'));
    }

    public function test_learn_page_shows_language_tabs_and_paths_directly(): void
    {
        $response = $this->actingAs(User::factory()->make(['name' => 'Siti Aminah']))->get('/belajar');

        $response->assertOk()
            ->assertViewIs('learn')
            ->assertViewHas('tracks', fn (array $tracks) => array_map(fn (Track $track) => $track->language->key, $tracks) === ['python', 'java', 'c'])
            ->assertSee('Halo, Siti!')
            ->assertSee('Pilih bahasamu, ikuti jalurnya')
            ->assertSeeInOrder(['Python', 'Java', 'C'])
            ->assertSee('Level 1: Dasar Pemrograman')
            ->assertSee('Pengenalan Pemrograman')
            // Landing-page sections are not repeated here.
            ->assertDontSee('bukan hafalan')
            ->assertDontSee('Lima langkah dari nol')
            ->assertDontSee('Coba sekarang, tanpa daftar');
    }

    public function test_start_button_says_lessons_are_coming_until_lesson_pages_exist(): void
    {
        $this->actingAs(User::factory()->make())
            ->get('/belajar')
            ->assertSee('Halaman pelajaran sedang kami siapkan.')
            ->assertDontSee(route('register'));
    }

    public function test_navbar_marks_learn_as_the_current_page(): void
    {
        $html = $this->actingAs(User::factory()->make())->get('/belajar')->getContent();

        $this->assertMatchesRegularExpression('#href="'.preg_quote(route('learn'), '#').'"\s+aria-current="page"#', $html);
        $this->assertSame(1, substr_count($html, 'aria-current="page"'));
    }

    public function test_learn_page_shows_a_friendly_message_when_content_cannot_be_loaded(): void
    {
        $this->mock(ContentRepository::class, function ($mock) {
            $mock->shouldReceive('languages')->andThrow(ContentException::invalid('content/python/level.yaml', 'broken'));
        });

        $this->actingAs(User::factory()->make())
            ->get('/belajar')
            ->assertOk()
            ->assertSee('Daftar bahasa belum bisa dimuat.')
            ->assertSee('Muat ulang');
    }
}
