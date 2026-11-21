<?php

namespace App\Content;

final readonly class Question
{
    /**
     * @param  string  $language  language key, e.g. "python"
     * @param  list<string>  $options  choices for multiple_choice and case_study
     * @param  list<string>  $alsoAccept  other correct answers for fill_in
     */
    public function __construct(
        public string $id,
        public string $language,
        public QuestionType $type,
        public string $prompt,
        public string $answer,
        public string $explanation,
        public int $xp,
        public ?string $code = null,
        public ?string $scenario = null,
        public array $options = [],
        public array $alsoAccept = [],
    ) {}

    /**
     * Every answer that counts as correct. Compare after trimming whitespace
     * at the start and end (see content/README.md).
     *
     * @return list<string>
     */
    public function acceptedAnswers(): array
    {
        return [$this->answer, ...$this->alsoAccept];
    }

    /**
     * Server-side check for practice answers. Same rule as content/README.md:
     * compare after trimming the start and end; line endings don't matter.
     */
    public function isCorrect(string $answer): bool
    {
        $normalize = fn (string $text) => trim(str_replace("\r\n", "\n", $text));

        foreach ($this->acceptedAnswers() as $accepted) {
            if ($normalize($accepted) === $normalize($answer)) {
                return true;
            }
        }

        return false;
    }

    public function expectsMultilineAnswer(): bool
    {
        return str_contains(trim($this->answer), "\n");
    }
}
