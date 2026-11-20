<?php

namespace Tests\Feature\Content;

use App\Content\ContentRepository;
use App\Content\Question;
use Tests\TestCase;

/**
 * Checks the real files in content/, so a content edit that breaks a rule in
 * content/README.md fails the test suite instead of the website.
 */
class ContentFilesTest extends TestCase
{
    public function test_every_configured_language_has_content_that_loads(): void
    {
        $languages = app(ContentRepository::class)->languages();

        $this->assertSame(array_keys(config('codequest.languages')), array_keys($languages));

        foreach ($languages as $language) {
            foreach ($language->levels as $level) {
                $this->assertNotEmpty($level->lessons, "{$level->id} has no lessons");
                $this->assertNotEmpty($level->questions, "{$level->id} has no questions");
            }
        }
    }

    public function test_ids_are_unique_across_all_content(): void
    {
        $ids = [];

        foreach ($this->allQuestions() as $question) {
            $ids[] = $question->id;
        }

        foreach (app(ContentRepository::class)->languages() as $language) {
            foreach ($language->levels as $level) {
                $ids[] = $level->id;

                foreach ($level->lessons as $lesson) {
                    $ids[] = $lesson->id;
                }
            }
        }

        $duplicates = array_keys(array_filter(array_count_values($ids), fn (int $count) => $count > 1));

        $this->assertSame([], $duplicates, 'Duplicate content ids: '.implode(', ', $duplicates));
    }

    public function test_option_questions_have_their_answer_among_the_options(): void
    {
        foreach ($this->allQuestions() as $question) {
            if ($question->type->hasOptions()) {
                $this->assertContains($question->answer, $question->options, "{$question->id}: answer is not one of the options");
            }
        }
    }

    public function test_fill_in_questions_have_a_blank_to_fill(): void
    {
        foreach ($this->allQuestions() as $question) {
            if ($question->type->value === 'fill_in') {
                $this->assertStringContainsString('____', (string) $question->code, "{$question->id}: code has no ____ blank");
            }
        }
    }

    public function test_homepage_demo_question_exists(): void
    {
        $id = config('codequest.home.demo_question');

        $this->assertNotNull(app(ContentRepository::class)->findQuestion($id), "Demo question {$id} is not in content/");
    }

    /**
     * @return list<Question>
     */
    private function allQuestions(): array
    {
        $questions = [];

        foreach (app(ContentRepository::class)->languages() as $language) {
            foreach ($language->levels as $level) {
                array_push($questions, ...$level->questions);
            }
        }

        return $questions;
    }
}
