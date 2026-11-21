<?php

namespace Tests\Feature;

use App\Content\ContentRepository;
use App\Models\User;
use FilesystemIterator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

class LessonPageTest extends TestCase
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

        $this->get('/belajar/python/1/pelajaran/1')->assertRedirect(route('login'));
    }

    public function test_first_lesson_of_every_language_loads(): void
    {
        foreach (['python', 'java', 'c'] as $language) {
            $this->get("/belajar/{$language}/1/pelajaran/1")
                ->assertOk()
                ->assertSee('Pengenalan Pemrograman')
                ->assertSee('Pelajaran 1 dari 3');
        }
    }

    public function test_lesson_markdown_is_rendered(): void
    {
        $this->get('/belajar/python/1/pelajaran/1');

        $this->get('/belajar/python/1/pelajaran/2')
            ->assertOk()
            ->assertSee('<h2>Coba ini</h2>', false)
            ->assertSee('<code class="language-python">', false)
            ->assertSee('<table>', false)
            ->assertDontSee('id: python-l1-variables');
    }

    public function test_lessons_link_to_each_other_and_the_last_one_starts_practice(): void
    {
        $this->get('/belajar/python/1/pelajaran/1')
            ->assertDontSee('Sebelumnya')
            ->assertSee(url('/belajar/python/1/pelajaran/2'))
            ->assertSee('Lanjut: Variabel');

        $this->get('/belajar/python/1/pelajaran/2')
            ->assertSee('Sebelumnya')
            ->assertSee(url('/belajar/python/1/pelajaran/1'))
            ->assertSee(url('/belajar/python/1/pelajaran/3'));

        $this->get('/belajar/python/1/pelajaran/3')
            ->assertSee('Mulai latihan soal')
            ->assertSee(url('/belajar/python/1/latihan/1'));
    }

    public function test_back_link_returns_to_the_level_page(): void
    {
        $this->get('/belajar/c/1/pelajaran/1')
            ->assertSee('href="'.url('/belajar/c/1').'" class="cq-back-link"', false)
            ->assertSee('Materi level 1');
    }

    public function test_unknown_language_level_or_lesson_is_not_found(): void
    {
        $this->get('/belajar/ruby/1/pelajaran/1')->assertNotFound();
        $this->get('/belajar/python/9/pelajaran/1')->assertNotFound();
        $this->get('/belajar/python/1/pelajaran/99')->assertNotFound();
        $this->get('/belajar/python/abc/pelajaran/1')->assertNotFound();
    }

    public function test_html_in_lesson_files_is_not_rendered(): void
    {
        $root = sys_get_temp_dir().'/codequest-lesson-'.bin2hex(random_bytes(6));
        mkdir($root.'/python/level-01/lessons', 0777, true);
        file_put_contents($root.'/python/level-01/level.yaml', "id: python-l1\ntitle: Dasar\norder: 1\ndescription: Deskripsi.\nunlock:\n  min_score: 70\n");
        file_put_contents($root.'/python/level-01/lessons/01-a.md', "---\nid: python-l1-a\ntitle: Pertama\norder: 1\nxp: 10\n---\n\nTeks <script>alert(1)</script> biasa.\n");

        $this->app->instance(ContentRepository::class, new ContentRepository($root, [
            'python' => ['name' => 'Python', 'tagline' => 'Mudah dibaca.', 'file' => 'main.py'],
        ]));

        $this->get('/belajar/python/1/pelajaran/1')
            ->assertOk()
            ->assertSee('Teks')
            ->assertDontSee('<script>alert(1)</script>', false);

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($root);
    }
}
