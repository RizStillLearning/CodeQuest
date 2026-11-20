<?php

namespace Tests\Feature\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_login_page_loads(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk ke CodeQuest')
            ->assertSee('Ingat saya di perangkat ini');
    }

    public function test_user_can_sign_in(): void
    {
        $user = User::factory()->create(['name' => 'Siti Aminah', 'email' => 'siti@example.com']);

        $this->post('/login', ['email' => 'siti@example.com', 'password' => 'password'])
            ->assertRedirect(route('learn'))
            ->assertSessionHas('status', 'Selamat datang kembali, Siti!');

        $this->assertAuthenticatedAs($user);
    }

    public function test_email_case_and_spaces_do_not_matter_when_signing_in(): void
    {
        $user = User::factory()->create(['email' => 'siti@example.com']);

        $this->post('/login', ['email' => ' Siti@Example.com ', 'password' => 'password'])
            ->assertRedirect(route('learn'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_shows_an_indonesian_error(): void
    {
        User::factory()->create(['email' => 'siti@example.com']);

        $this->from('/login')->post('/login', ['email' => 'siti@example.com', 'password' => 'salah-sandi'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['email' => 'Email atau kata sandi salah.']);

        $this->assertGuest();
    }

    public function test_sign_in_is_locked_after_too_many_failed_attempts(): void
    {
        User::factory()->create(['email' => 'siti@example.com']);

        for ($i = 0; $i < LoginRequest::MAX_ATTEMPTS; $i++) {
            $this->post('/login', ['email' => 'siti@example.com', 'password' => 'salah-sandi']);
        }

        // Even the right password is refused while locked out.
        $response = $this->post('/login', ['email' => 'siti@example.com', 'password' => 'password']);

        $response->assertSessionHasErrors('email');
        $this->assertStringStartsWith('Terlalu banyak percobaan masuk.', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_remember_me_sets_a_remember_cookie(): void
    {
        $user = User::factory()->create(['email' => 'siti@example.com']);

        $response = $this->post('/login', ['email' => 'siti@example.com', 'password' => 'password', 'remember' => '1']);

        $response->assertCookie(auth()->guard('web')->getRecallerName());
        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_guests_are_sent_to_login_and_back_to_where_they_were_going(): void
    {
        $this->get('/belajar')->assertRedirect(route('login'));

        User::factory()->create(['email' => 'siti@example.com']);

        $this->post('/login', ['email' => 'siti@example.com', 'password' => 'password'])
            ->assertRedirect(url('/belajar'));
    }

    public function test_learn_page_greets_the_user(): void
    {
        $this->actingAs(User::factory()->create(['name' => 'Siti Aminah']))
            ->get('/belajar')
            ->assertOk()
            ->assertViewIs('learn')
            ->assertViewHas('user', fn (User $user) => $user->name === 'Siti Aminah')
            ->assertSee('Halo, Siti!');
    }

    public function test_user_can_sign_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect(route('home'))
            ->assertSessionHas('status', 'Kamu sudah keluar. Sampai jumpa lagi!');

        $this->assertGuest();
    }

    public function test_sign_out_needs_a_post_request(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/logout')
            ->assertMethodNotAllowed();

        $this->assertAuthenticated();
    }

    public function test_navbar_shows_app_features_and_account_menu_when_signed_in(): void
    {
        $this->actingAs(User::factory()->create(['name' => 'Siti Aminah']))
            ->get('/belajar')
            ->assertOk()
            ->assertSeeInOrder(['Belajar', 'Progres', 'Peringkat', 'Diskusi'])
            ->assertSee(route('leaderboard'))
            ->assertSee(route('forum'))
            ->assertSee('Keluar')
            ->assertDontSee('Cara Kerja')
            ->assertDontSee('Daftar sekarang');
    }
}
