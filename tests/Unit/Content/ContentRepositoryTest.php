<?php

namespace Tests\Unit\Content;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\Content\QuestionType;
use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ContentRepositoryTest extends TestCase
{
    private string $root;

    protected function setUp(): void
    {
        parent::setUp();

        $this->root = sys_get_temp_dir().'/codequest-content-'.bin2hex(random_bytes(6));
        mkdir($this->root, 0777, true);
    }

    protected function tearDown(): void
    {
        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->root, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($items as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }

        rmdir($this->root);

        parent::tearDown();
    }

    public function test_languages_follow_config_order_and_skip_languages_without_content(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->writeLevel('c', 'level-01-basics', order: 1);

        $repository = $this->repository(['c' => ['name' => 'C'], 'java' => ['name' => 'Java'], 'python' => ['name' => 'Python']]);

        $this->assertSame(['c', 'python'], array_keys($repository->languages()));
    }

    public function test_language_uses_config_metadata(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);

        $language = $this->repository(['python' => ['name' => 'Python', 'tagline' => 'Mudah dibaca.', 'file' => 'main.py']])
            ->languages()['python'];

        $this->assertSame('Python', $language->name);
        $this->assertSame('Mudah dibaca.', $language->tagline);
        $this->assertSame('main.py', $language->fileName);
        $this->assertSame('py', $language->extension());
    }

    public function test_level_summary_counts_lessons_questions_and_xp(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/lessons/01-intro.md', $this->lesson('python-l1-intro', 'Pengenalan', order: 1, xp: 20));
        $this->write('python/level-01-basics/lessons/02-variables.md', $this->lesson('python-l1-variables', 'Variabel', order: 2, xp: 15));
        $this->write('python/level-01-basics/questions.yaml', <<<'YAML'
            - id: python-l1-q01
              type: predict_output
              prompt: Apa output dari kode ini?
              code: |
                print(1 + 1)
              answer: "2"
              explanation: >-
                1 + 1 adalah 2.
              xp: 10

            - id: python-l1-q02
              type: multiple_choice
              prompt: Pilih yang benar.
              options:
                - "a"
                - "b"
              answer: "a"
              explanation: >-
                Jawabannya a.
              xp: 5
            YAML);

        $level = $this->repository(['python' => ['name' => 'Python']])->languages()['python']->firstLevel();

        $this->assertSame('python-l1', $level->id);
        $this->assertSame('Dasar Pemrograman', $level->title);
        $this->assertSame('Deskripsi level.', $level->description);
        $this->assertSame(70, $level->minScore);
        $this->assertSame(['Pengenalan', 'Variabel'], array_map(fn ($lesson) => $lesson->title, $level->lessons));
        $this->assertCount(2, $level->questions);
        $this->assertSame(35, $level->lessonXp());
        $this->assertSame(15, $level->questionXp());
        $this->assertSame(50, $level->totalXp());
        $this->assertSame(2, $level->questionTypeCount());
    }

    public function test_lessons_are_sorted_by_order_not_file_name(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/lessons/01-a.md', $this->lesson('python-l1-a', 'Kedua', order: 2, xp: 10));
        $this->write('python/level-01-basics/lessons/02-b.md', $this->lesson('python-l1-b', 'Pertama', order: 1, xp: 10));

        $level = $this->repository(['python' => []])->languages()['python']->firstLevel();

        $this->assertSame(['Pertama', 'Kedua'], array_map(fn ($lesson) => $lesson->title, $level->lessons));
    }

    public function test_levels_are_sorted_by_order_and_level_after_returns_the_next_one(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1, id: 'python-l1');
        $this->writeLevel('python', 'level-02-next', order: 2, id: 'python-l2');

        $language = $this->repository(['python' => []])->languages()['python'];

        $this->assertSame(['python-l1', 'python-l2'], array_map(fn ($level) => $level->id, $language->levels));
        $this->assertSame('python-l2', $language->levelAfter($language->levels[0])?->id);
        $this->assertNull($language->levelAfter($language->levels[1]));
    }

    public function test_a_level_without_questions_file_has_no_questions(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);

        $level = $this->repository(['python' => []])->languages()['python']->firstLevel();

        $this->assertSame([], $level->questions);
        $this->assertSame(0, $level->questionXp());
    }

    public function test_find_question_returns_the_question_with_all_accepted_answers(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/questions.yaml', <<<'YAML'
            - id: python-l1-q03
              type: fill_in
              prompt: Lengkapi kodenya.
              code: |
                ____("Halo")
              answer: "print"
              also_accept:
                - "print "
              explanation: >-
                print() menampilkan teks.
              xp: 10
            YAML);

        $repository = $this->repository(['python' => []]);
        $question = $repository->findQuestion('python-l1-q03');

        $this->assertNotNull($question);
        $this->assertSame('python', $question->language);
        $this->assertSame(QuestionType::FillIn, $question->type);
        $this->assertSame("____(\"Halo\")\n", $question->code);
        $this->assertSame(['print', 'print '], $question->acceptedAnswers());
        $this->assertFalse($question->expectsMultilineAnswer());
        $this->assertNull($repository->findQuestion('does-not-exist'));
    }

    public function test_invalid_yaml_throws_a_content_exception_naming_the_file(): void
    {
        $this->write('python/level-01-basics/level.yaml', "id: [not closed\n");

        $this->expectException(ContentException::class);
        $this->expectExceptionMessage('content/python/level-01-basics/level.yaml');

        $this->repository(['python' => []])->languages();
    }

    public function test_unquoted_answer_is_rejected(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/questions.yaml', <<<'YAML'
            - id: python-l1-q01
              type: predict_output
              prompt: Apa outputnya?
              answer: 10
              explanation: >-
                Sepuluh.
              xp: 10
            YAML);

        $this->expectException(ContentException::class);
        $this->expectExceptionMessage('field `answer`');

        $this->repository(['python' => []])->languages();
    }

    public function test_unknown_question_type_is_rejected(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/questions.yaml', <<<'YAML'
            - id: python-l1-q01
              type: true_false
              prompt: Benar atau salah?
              answer: "benar"
              explanation: >-
                Benar.
              xp: 5
            YAML);

        $this->expectException(ContentException::class);
        $this->expectExceptionMessage('field `type`');

        $this->repository(['python' => []])->languages();
    }

    public function test_lesson_without_front_matter_is_rejected(): void
    {
        $this->writeLevel('python', 'level-01-basics', order: 1);
        $this->write('python/level-01-basics/lessons/01-intro.md', "## Tanpa front matter\n");

        $this->expectException(ContentException::class);
        $this->expectExceptionMessage('front matter');

        $this->repository(['python' => []])->languages();
    }

    /**
     * @param  array<string, array<string, string>>  $config
     */
    private function repository(array $config): ContentRepository
    {
        return new ContentRepository($this->root, $config);
    }

    private function writeLevel(string $language, string $folder, int $order, ?string $id = null): void
    {
        $id ??= "{$language}-l{$order}";

        $this->write("{$language}/{$folder}/level.yaml", <<<YAML
            id: {$id}
            title: Dasar Pemrograman
            order: {$order}
            description: Deskripsi level.
            unlock:
              min_score: 70
            YAML);
    }

    private function lesson(string $id, string $title, int $order, int $xp): string
    {
        return "---\nid: {$id}\ntitle: {$title}\norder: {$order}\nxp: {$xp}\n---\n\n## Coba ini\n";
    }

    private function write(string $path, string $contents): void
    {
        $file = $this->root.'/'.$path;

        if (! is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        file_put_contents($file, $contents);
    }
}
