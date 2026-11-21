<?php

namespace App\Content;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Reads languages, levels, lessons, and questions from the content/ folder.
 *
 * The folder layout and field rules are documented in content/README.md.
 * This class only reads content. It never touches user progress or XP.
 */
class ContentRepository
{
    /** @var array<string, Language>|null */
    private ?array $languages = null;

    /**
     * @param  string  $basePath  absolute path of the content/ folder
     * @param  array<string, array{name: string, tagline: string, file: string}>  $languageConfig  enabled languages, in display order
     */
    public function __construct(
        private readonly string $basePath,
        private readonly array $languageConfig,
    ) {}

    /**
     * Enabled languages that have at least one level, in config order.
     *
     * @return array<string, Language>
     *
     * @throws ContentException
     */
    public function languages(): array
    {
        if ($this->languages !== null) {
            return $this->languages;
        }

        $languages = [];

        foreach ($this->languageConfig as $key => $meta) {
            $levels = $this->loadLevels($key);

            if ($levels === []) {
                continue;
            }

            $languages[$key] = new Language(
                key: $key,
                name: $meta['name'],
                tagline: $meta['tagline'],
                fileName: $meta['file'],
                levels: $levels,
            );
        }

        return $this->languages = $languages;
    }

    /**
     * @throws ContentException
     */
    public function findQuestion(string $id): ?Question
    {
        foreach ($this->languages() as $language) {
            foreach ($language->levels as $level) {
                foreach ($level->questions as $question) {
                    if ($question->id === $id) {
                        return $question;
                    }
                }
            }
        }

        return null;
    }

    /**
     * @return list<Level>
     */
    private function loadLevels(string $language): array
    {
        $directories = glob($this->basePath.'/'.$language.'/level-*', GLOB_ONLYDIR) ?: [];

        $levels = array_map(fn (string $directory) => $this->loadLevel($language, $directory), $directories);

        usort($levels, fn (Level $a, Level $b) => $a->order <=> $b->order);

        return $levels;
    }

    private function loadLevel(string $language, string $directory): Level
    {
        $file = $directory.'/level.yaml';
        $data = $this->mapping($this->parseYaml($this->read($file), $file), $file);

        $lessons = array_map(fn (string $lessonFile) => $this->loadLesson($lessonFile), glob($directory.'/lessons/*.md') ?: []);
        usort($lessons, fn (Lesson $a, Lesson $b) => $a->order <=> $b->order);

        $questionsFile = $directory.'/questions.yaml';
        $questions = is_file($questionsFile) ? $this->loadQuestions($language, $questionsFile) : [];

        $minScore = $data['unlock']['min_score'] ?? null;

        if (! is_int($minScore)) {
            throw ContentException::invalidField($this->relative($file), 'unlock.min_score', 'a whole number');
        }

        return new Level(
            id: $this->text($data, 'id', $file),
            title: $this->text($data, 'title', $file),
            order: $this->integer($data, 'order', $file),
            description: $this->text($data, 'description', $file),
            minScore: $minScore,
            lessons: $lessons,
            questions: $questions,
        );
    }

    private function loadLesson(string $file): Lesson
    {
        $contents = $this->read($file);

        if (! preg_match('/\A(?:\xEF\xBB\xBF)?---\R(.*?)\R---(?:\R|\z)/s', $contents, $matches)) {
            throw ContentException::invalid($this->relative($file), 'missing front matter (a --- block at the top of the file)');
        }

        $data = $this->mapping($this->parseYaml($matches[1], $file), $file);
        $body = trim(substr($contents, strlen($matches[0])));

        if ($body === '') {
            throw ContentException::invalid($this->relative($file), 'the lesson has no content after the front matter');
        }

        return new Lesson(
            id: $this->text($data, 'id', $file),
            title: $this->text($data, 'title', $file),
            order: $this->integer($data, 'order', $file),
            xp: $this->integer($data, 'xp', $file),
            body: $body,
        );
    }

    /**
     * @return list<Question>
     */
    private function loadQuestions(string $language, string $file): array
    {
        $items = $this->parseYaml($this->read($file), $file) ?? [];

        if (! is_array($items) || ! array_is_list($items)) {
            throw ContentException::invalid($this->relative($file), 'expected a list of questions');
        }

        return array_map(fn (mixed $item) => $this->makeQuestion($language, $item, $file), $items);
    }

    private function makeQuestion(string $language, mixed $item, string $file): Question
    {
        $data = $this->mapping($item, $file);
        $id = $this->text($data, 'id', $file);

        $type = is_string($data['type'] ?? null) ? QuestionType::tryFrom($data['type']) : null;

        if ($type === null) {
            $allowed = implode(', ', array_map(fn (QuestionType $type) => $type->value, QuestionType::cases()));

            throw ContentException::invalidField($this->relative($file), 'type', "one of: {$allowed}", $id);
        }

        return new Question(
            id: $id,
            language: $language,
            type: $type,
            prompt: $this->text($data, 'prompt', $file, $id),
            answer: $this->text($data, 'answer', $file, $id),
            explanation: $this->text($data, 'explanation', $file, $id),
            xp: $this->integer($data, 'xp', $file, $id),
            code: $this->optionalText($data, 'code', $file, $id),
            scenario: $this->optionalText($data, 'scenario', $file, $id),
            options: $type->hasOptions() ? $this->textList($data, 'options', $file, $id) : [],
            alsoAccept: array_key_exists('also_accept', $data) ? $this->textList($data, 'also_accept', $file, $id) : [],
        );
    }

    private function read(string $file): string
    {
        $contents = is_file($file) ? file_get_contents($file) : false;

        if ($contents === false) {
            throw ContentException::invalid($this->relative($file), 'file is missing or could not be read');
        }

        return $contents;
    }

    private function parseYaml(string $yaml, string $file): mixed
    {
        try {
            return Yaml::parse($yaml);
        } catch (ParseException $e) {
            throw ContentException::invalid($this->relative($file), $e->getMessage(), $e);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function mapping(mixed $value, string $file): array
    {
        if (! is_array($value) || ($value !== [] && array_is_list($value))) {
            throw ContentException::invalid($this->relative($file), 'expected key: value pairs');
        }

        return $value;
    }

    /**
     * Answers and options must be quoted in YAML so they stay text (content/README.md),
     * so only real strings are accepted here.
     */
    private function text(array $data, string $key, string $file, ?string $id = null): string
    {
        $value = $data[$key] ?? null;

        if (! is_string($value) || trim($value) === '') {
            throw ContentException::invalidField($this->relative($file), $key, 'non-empty text (quote it in YAML)', $id);
        }

        return $value;
    }

    private function optionalText(array $data, string $key, string $file, ?string $id = null): ?string
    {
        return ($data[$key] ?? null) === null ? null : $this->text($data, $key, $file, $id);
    }

    private function integer(array $data, string $key, string $file, ?string $id = null): int
    {
        $value = $data[$key] ?? null;

        if (! is_int($value) || $value < 0) {
            throw ContentException::invalidField($this->relative($file), $key, 'a whole number of 0 or more', $id);
        }

        return $value;
    }

    /**
     * @return list<string>
     */
    private function textList(array $data, string $key, string $file, ?string $id = null): array
    {
        $value = $data[$key] ?? null;

        if (! is_array($value) || $value === [] || ! array_is_list($value)) {
            throw ContentException::invalidField($this->relative($file), $key, 'a non-empty list of quoted text', $id);
        }

        foreach ($value as $item) {
            if (! is_string($item)) {
                throw ContentException::invalidField($this->relative($file), $key, 'a non-empty list of quoted text', $id);
            }
        }

        return $value;
    }

    private function relative(string $file): string
    {
        return 'content/'.ltrim(str_replace('\\', '/', substr($file, strlen($this->basePath))), '/');
    }
}
