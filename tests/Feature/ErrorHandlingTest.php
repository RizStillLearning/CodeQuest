<?php

namespace Tests\Feature;

use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ErrorHandlingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_missing_page_shows_a_friendly_indonesian_page(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan')
            ->assertSee('Kembali ke beranda');
    }

    public function test_server_error_page_offers_a_retry(): void
    {
        config(['app.debug' => false]);
        Route::get('/_test/boom', fn () => throw new \RuntimeException('boom'));

        $this->get('/_test/boom')
            ->assertStatus(500)
            ->assertSee('Ada yang tidak beres di sisi kami')
            ->assertSee('Coba lagi')
            ->assertDontSee('RuntimeException');
    }

    public function test_expired_form_goes_back_with_input_but_without_passwords(): void
    {
        Route::post('/_test/expired', fn () => throw new TokenMismatchException)->middleware('web');

        $response = $this->from('/login')->post('/_test/expired', [
            'email' => 'siti@example.com',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status', 'Halaman ini sudah terlalu lama dibuka. Silakan kirim ulang formulirnya.');
        $response->assertSessionHasInput('email', 'siti@example.com');
        $this->assertNull(session()->getOldInput('password'));
    }
}
