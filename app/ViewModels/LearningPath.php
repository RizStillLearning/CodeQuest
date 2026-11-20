<?php

namespace App\ViewModels;

use App\Content\Level;
use App\Content\Track;

/**
 * A level drawn as a winding path: one node per lesson, then the practice
 * questions, then the next level. Locked steps are greyed out.
 *
 * Controllers build it and pass it to resources/views/partials/learning-path.blade.php.
 */
final class LearningPath
{
    /**
     * Horizontal shift per step, as a % of the path width.
     */
    public const SHIFT_PERCENT = 18;

    /**
     * Nodes snake right and back: 0, 1, 2, 1, 0, 1, ...
     */
    private const SHIFT_PATTERN = [0, 1, 2, 1];

    /**
     * @var list<array{kind: string, title: string, meta: string, open: bool, shift: int}>
     */
    public array $steps;

    /**
     * SVG path through the node centers. x is a % of the path width and each
     * row is 100 units tall, matching the CSS row height.
     */
    public string $line;

    public function __construct(public Level $level, public ?Level $nextLevel = null)
    {
        $this->steps = $this->buildSteps();
        $this->line = $this->buildLine();
    }

    /**
     * One path per track, keyed by language key, for partials/language-tracks.
     *
     * @param  list<Track>  $tracks
     * @return array<string, self>
     */
    public static function forTracks(array $tracks): array
    {
        $paths = [];

        foreach ($tracks as $track) {
            $paths[$track->language->key] = new self($track->level, $track->nextLevel);
        }

        return $paths;
    }

    /**
     * Visitor preview: the first lesson is open and everything after it is locked.
     * Once progress tracking exists, open/locked comes from the learner's progress.
     *
     * @return list<array{kind: string, title: string, meta: string, open: bool, shift: int}>
     */
    private function buildSteps(): array
    {
        $steps = [];

        foreach ($this->level->lessons as $index => $lesson) {
            $steps[] = [
                'kind' => 'Pelajaran '.($index + 1),
                'title' => $lesson->title,
                'meta' => '+'.$lesson->xp.' XP',
                'open' => $index === 0,
            ];
        }

        if ($this->level->questions !== []) {
            $steps[] = [
                'kind' => 'Latihan',
                'title' => count($this->level->questions).' soal latihan',
                'meta' => '+'.$this->level->questionXp().' XP · '.$this->level->questionTypeCount().' jenis soal',
                'open' => false,
            ];
        }

        $steps[] = [
            'kind' => 'Level '.($this->level->order + 1),
            'title' => $this->nextLevel?->title ?? 'Segera hadir',
            'meta' => $this->nextLevel ? 'Terbuka setelah Level '.$this->level->order.' selesai' : 'Materinya sedang kami siapkan',
            'open' => false,
        ];

        foreach ($steps as $index => $step) {
            $steps[$index]['shift'] = self::SHIFT_PATTERN[$index % count(self::SHIFT_PATTERN)];
        }

        return $steps;
    }

    private function buildLine(): string
    {
        $line = '';

        foreach ($this->steps as $index => $step) {
            $x = $step['shift'] * self::SHIFT_PERCENT;
            $y = $index * 100 + 50;

            if ($index === 0) {
                $line = "M {$x} {$y}";

                continue;
            }

            // Curve from the previous node, bending at the midpoint between rows.
            $previousX = $this->steps[$index - 1]['shift'] * self::SHIFT_PERCENT;
            $line .= " C {$previousX} ".($y - 50).", {$x} ".($y - 50).", {$x} {$y}";
        }

        return $line;
    }
}
