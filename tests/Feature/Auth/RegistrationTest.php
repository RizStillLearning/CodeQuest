<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_register_page_loads(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('Buat akun CodeQuest')
            ->assertSee('Kata sandi');
    }

    public function test_new_user_can_register_and_is_signed_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertRedirect(route('learn'));
        $response->assertSessionHas('status', 'Akunmu sudah jadi. Selamat datang di CodeQuest, Budi!');

        $user = User::where('email', 'budi@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('Budi Santoso', $user->name);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
        $this->assertNotSame('rahasia123', $user->password);
    }

    public function test_email_is_trimmed_and_stored_lowercase(): void
    {
        $this->post('/register', [
            'name' => 'Siti',
            'email' => '  Siti@Example.COM ',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('learn'));

        $this->assertDatabaseHas('users', ['email' => 'siti@example.com']);
    }

    public function test_email_must_be_unique_ignoring_case(): void
    {
        User::factory()->create(['email' => 'budi@example.com']);

        $this->from('/register')->post('/register', [
            'name' => 'Budi Lain',
            'email' => 'BUDI@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])
            ->assertRedirect('/register')
            ->assertSessionHasErrors(['email' => 'Email ini sudah terdaftar. Coba masuk, atau pakai email lain.']);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }

    public function test_required_fields_show_indonesian_messages(): void
    {
        $this->from('/register')->post('/register', [])
            ->assertRedirect('/register')
            ->assertSessionHasErrors([
                'name' => 'Nama wajib diisi.',
                'email' => 'Email wajib diisi.',
                'password' => 'Kata sandi wajib diisi.',
            ]);

        $this->assertGuest();
    }

    public function test_password_must_be_at_least_eight_characters_and_confirmed(): void
    {
        $this->from('/register')->post('/register', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
        ])->assertSessionHasErrors(['password' => 'Kata sandi minimal 8 karakter.']);

        // The mismatch is reported on the confirmation field, where the learner fixes it.
        $this->from('/register')->post('/register', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia124',
        ])
            ->assertSessionHasErrors(['password_confirmation' => 'Kata sandi tidak cocok. Ketik ulang kata sandi yang sama.'])
            ->assertSessionDoesntHaveErrors('password');

        $this->assertGuest();
    }

    public function test_old_input_is_kept_but_never_the_password(): void
    {
        $this->from('/register')->post('/register', [
            'name' => 'Budi',
            'email' => 'bukan-email',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $this->get('/register')
            ->assertSee('value="Budi"', false)
            ->assertSee('value="bukan-email"', false)
            ->assertDontSee('rahasia123');
    }

    public function test_signed_in_users_are_sent_to_learn_instead_of_the_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/register')
            ->assertRedirect(route('learn'));
    }
}
