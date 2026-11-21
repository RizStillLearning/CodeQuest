<?php

namespace Tests\Feature\Content;

use App\Content\ContentRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Opens every level, lesson, and question page from the real content/, so new content
 * that breaks a page fails the tests instead of the website. Steps unlock in
 * order, so it studies each language like a learner: every lesson, then every
 * question answered with its own answer, which must pass to open the next level.
 */
class ContentPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_lesson_and_question_page_loads(): void
    {
        $this->withoutVite();
        $this->actingAs(User::factory()->create());

        foreach (app(ContentRepository::class)->languages() as $language) {
            $this->get("/belajar/{$language->key}")->assertOk();

            foreach ($language->levels as $level) {
                $this->get("/belajar/{$language->key}/{$level->order}")
                    ->assertOk()
                    ->assertSee($level->title);

                foreach ($level->lessons as $lesson) {
                    $this->get("/belajar/{$language->key}/{$level->order}/pelajaran/{$lesson->order}")
                        ->assertOk()
                        ->assertSee($lesson->title);
                }

                foreach ($level->questions as $index => $question) {
                    $this->get("/belajar/{$language->key}/{$level->order}/latihan/".($index + 1))
                        ->assertOk()
                        ->assertSee($question->prompt);
                }

                $this->answerQuestions($language->key, $level->order);
                $this->get("/belajar/{$language->key}/{$level->order}/latihan/hasil")
                    ->assertSee(count($level->questions).' dari '.count($level->questions).' soal benar');
            }
        }
    }
}
