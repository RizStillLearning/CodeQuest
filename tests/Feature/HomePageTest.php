<?php

namespace Tests\Feature;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\Content\Track;
use App\Models\User;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_homepage_shows_languages_and_level_paths_from_content(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Belajar coding lewat');
        $response->assertSeeInOrder(['Python', 'Java', 'C']);
        $response->assertSee('Level 1: Dasar Pemrograman');
        $response->assertSee('Pengenalan Pemrograman');
        $response->assertSee('10 soal latihan');
    }

    public function test_homepage_shows_the_configured_demo_question(): void
    {
        $question = app(ContentRepository::class)->findQuestion(config('codequest.home.demo_question'));

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-try-question', false);
        $response->assertSee($question->prompt);
        $response->assertSee($question->explanation);
    }

    public function test_homepage_still_loads_when_the_demo_question_is_missing(): void
    {
        config(['codequest.home.demo_question' => 'does-not-exist']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('data-try-question', false);
        $response->assertSee('Level 1: Dasar Pemrograman');
    }

    public function test_homepage_shows_a_friendly_message_when_content_cannot_be_loaded(): void
    {
        $this->mock(ContentRepository::class, function ($mock) {
            $mock->shouldReceive('languages')->andThrow(ContentException::invalid('content/python/level.yaml', 'broken'));
        });

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Daftar bahasa belum bisa dimuat.');
        $response->assertSee('Muat ulang');
        $response->assertDontSee('data-try-question', false);
    }

    public function test_guests_see_sign_up_and_sign_in_links(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('register'))
            ->assertSee(route('login'))
            ->assertSee('Daftar sekarang');
    }

    public function test_signed_in_users_go_to_learn_instead_of_the_landing_page(): void
    {
        $this->actingAs(User::factory()->make())
            ->get('/')
            ->assertRedirect(route('learn'));
    }

    public function test_controller_prepares_the_page_data(): void
    {
        $this->get('/')
            ->assertViewIs('home')
            ->assertViewHas('tracks', fn (array $tracks) => array_map(fn (Track $track) => $track->language->key, $tracks) === ['python', 'java', 'c'])
            ->assertViewHas('reasons', fn (array $reasons) => count($reasons) === 3)
            ->assertViewHas('steps', fn (array $steps) => count($steps) === 5)
            ->assertViewHas('questionTypes', fn (array $types) => count($types) === 4);
    }
}
