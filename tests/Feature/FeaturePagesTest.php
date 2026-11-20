<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Progress, leaderboard, and forum are in the navbar but not built yet.
 */
class FeaturePagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function features(): array
    {
        return [
            'progress' => ['/progres', 'Progres belajar'],
            'leaderboard' => ['/peringkat', 'Papan peringkat'],
            'forum' => ['/diskusi', 'Forum diskusi'],
        ];
    }

    #[DataProvider('features')]
    public function test_guests_are_sent_to_login(string $url): void
    {
        $this->get($url)->assertRedirect(route('login'));
    }

    #[DataProvider('features')]
    public function test_signed_in_users_see_a_coming_soon_page(string $url, string $title): void
    {
        $this->actingAs(User::factory()->make())
            ->get($url)
            ->assertOk()
            ->assertViewIs('coming-soon')
            ->assertSee($title)
            ->assertSee('Segera hadir')
            ->assertSee('Kembali belajar')
            ->assertSee('aria-current="page"', false);
    }
}
