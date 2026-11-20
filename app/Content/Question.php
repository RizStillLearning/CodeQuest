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

    public function expectsMultilineAnswer(): bool
    {
        return str_contains(trim($this->answer), "\n");
    }
}
