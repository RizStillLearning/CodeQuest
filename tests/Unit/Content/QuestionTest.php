<?php

namespace Tests\Unit\Content;

use App\Content\Question;
use App\Content\QuestionType;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function test_exact_answer_is_correct(): void
    {
        $this->assertTrue($this->question('53')->isCorrect('53'));
        $this->assertFalse($this->question('53')->isCorrect('8'));
    }

    public function test_spaces_and_newlines_around_the_answer_are_ignored(): void
    {
        $this->assertTrue($this->question('53')->isCorrect("  53\n"));
    }

    public function test_multiline_output_matches_with_any_line_endings(): void
    {
        $question = $this->question("Halo\nCodeQuest");

        $this->assertTrue($question->isCorrect("Halo\r\nCodeQuest"));
        $this->assertFalse($question->isCorrect('Halo CodeQuest'));
    }

    public function test_output_is_case_sensitive(): void
    {
        $this->assertFalse($this->question('print')->isCorrect('Print'));
    }

    public function test_also_accept_answers_are_correct(): void
    {
        $question = new Question('q', 'python', QuestionType::FillIn, 'Lengkapi.', 'print', 'Karena.', 10, alsoAccept: ['print ']);

        $this->assertTrue($question->isCorrect('print '));
    }

    private function question(string $answer): Question
    {
        return new Question('q', 'python', QuestionType::PredictOutput, 'Apa outputnya?', $answer, 'Karena.', 10);
    }
}
