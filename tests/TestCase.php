<?php

namespace Tests;

use App\Content\ContentRepository;
use App\Content\Level;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Opens every lesson of a level in the real content/, which completes them.
     */
    protected function readLessons(string $language, int $level): void
    {
        foreach ($this->contentLevel($language, $level)->lessons as $lesson) {
            $this->get("/belajar/{$language}/{$level}/pelajaran/{$lesson->order}")->assertOk();
        }
    }

    /**
     * Answers every practice question of a level in the real content/: the first
     * $correct of them right (all when null) and the rest wrong.
     */
    protected function answerQuestions(string $language, int $level, ?int $correct = null): void
    {
        foreach ($this->contentLevel($language, $level)->questions as $index => $question) {
            $answer = match (true) {
                $correct === null || $index < $correct => $question->answer,
                $question->type->hasOptions() => current(array_diff($question->options, [$question->answer])),
                default => 'jawaban salah',
            };
            $url = "/belajar/{$language}/{$level}/latihan/".($index + 1);

            $this->post($url, ['answer' => $answer])->assertRedirect(url($url));
        }
    }

    private function contentLevel(string $language, int $level): Level
    {
        return app(ContentRepository::class)->languages()[$language]->level($level);
    }
}
