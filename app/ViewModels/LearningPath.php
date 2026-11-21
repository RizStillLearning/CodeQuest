<?php

namespace App\ViewModels;

use App\Content\Language;
use App\Content\Level;
use App\Progress\LearnerProgress;

/**
 * A learning path drawn as one winding line of nodes, at two zoom levels:
 * forLanguage() has a node per level, and forLevel() has one level's flag, its
 * lessons and practice, then the next level. After the last level the path
 * ends with a "coming soon" node.
 *
 * Steps the learner finished are marked done; the first open one that isn't
 * done is the current one, where they continue. Everything after it is locked
 * (see LearnerProgress).
 */
final class LearningPath
{
    /**
     * Horizontal shift per step, as a % of the path width.
     */
    public const SHIFT_PERCENT = 18;

    private const SHIFT_PATTERN = [0, 1, 2, 1];

    /**
     * Steps without a url can't be opened: the flag of the level being shown,
     * and locked steps.
     *
     * @var list<array{type: string, kind: string, title: string, meta: string, icon: string, url: ?string, done: bool, locked: bool, current: bool, badge: ?string, shift: int}>
     */
    public array $steps;

    /**
     * SVG path through the node centers. x is a % of the path width and each
     * row is 100 units tall, matching the CSS row height.
     */
    public string $line;

    /**
     * The solid part of the line, from the start up to the current step.
     * Empty until the learner has finished a step on this path.
     */
    public string $progressLine = '';

    /**
     * Per level id: lessons and practice done, in total, where the level's
     * button goes (null while the level is locked), and whether it's the level
     * to continue (the first one not finished).
     *
     * @var array<string, array{done: int, total: int, percent: int, finished: bool, url: ?string, action: string, locked: bool, next: bool}>
     */
    public array $levelProgress;

    /**
     * @param  non-empty-list<Level>  $levels  the levels on this path, in order
     * @param  list<array>  $steps  built by step(), in order
     */
    private function __construct(
        public Language $language,
        public array $levels,
        array $steps,
        array $levelProgress,
    ) {
        $this->levelProgress = $levelProgress;

        foreach ($this->levelProgress as $id => $progress) {
            if (! $progress['finished']) {
                $this->levelProgress[$id]['next'] = true;
                break;
            }
        }

        $started = array_sum(array_column($this->levelProgress, 'done')) > 0;

        foreach ($steps as $index => $step) {
            if ($step['url'] !== null && ! $step['done']) {
                $steps[$index]['current'] = true;
                $steps[$index]['icon'] = 'play';
                $steps[$index]['badge'] = $started ? 'Lanjutkan' : 'Mulai di sini';
                break;
            }
        }

        foreach ($steps as $index => $step) {
            $steps[$index]['shift'] = self::SHIFT_PATTERN[$index % count(self::SHIFT_PATTERN)];
        }

        $this->steps = $steps;
        $this->line = $this->buildLine(count($steps) - 1);

        $done = array_keys(array_filter(array_column($steps, 'done')));

        if ($done !== []) {
            $current = array_search(true, array_column($steps, 'current'), true);
            $this->progressLine = $this->buildLine($current === false ? max($done) : $current);
        }
    }

    /**
     * A node per level, for the language's path page. Each level's button goes to its page.
     */
    public static function forLanguage(Language $language, LearnerProgress $progress): self
    {
        $steps = [];
        $levelProgress = [];

        foreach ($language->levels as $level) {
            $url = $progress->isLevelOpen($level) ? route('levels.show', [$language->key, $level->order]) : null;
            $levelProgress[$level->id] = self::levelProgress(self::materials($language, $level, $progress), $url);
            $steps[] = self::levelStep($level, $url, done: $levelProgress[$level->id]['finished'], locked: $url === null);
        }

        $steps[] = self::comingSoon($language->levels[array_key_last($language->levels)]);

        return new self($language, $language->levels, $steps, $levelProgress);
    }

    /**
     * One level's lessons and practice, for the level's page. Its button goes
     * to the step to continue with.
     */
    public static function forLevel(Language $language, Level $level, LearnerProgress $progress): self
    {
        $materials = self::materials($language, $level, $progress);
        $continue = array_values(array_filter($materials, fn (array $step) => ! $step['done']))[0] ?? $materials[0];
        $levelProgress = self::levelProgress($materials, $continue['url']);
        $nextLevel = $language->levelAfter($level);

        if ($nextLevel) {
            $nextUrl = $progress->isLevelOpen($nextLevel) ? route('levels.show', [$language->key, $nextLevel->order]) : null;
            $end = self::levelStep($nextLevel, $nextUrl, done: $progress->isLevelDone($nextLevel), locked: $nextUrl === null);
        } else {
            $end = self::comingSoon($level);
        }

        $steps = [
            self::levelStep($level, null, done: $levelProgress['finished'], locked: ! $progress->isLevelOpen($level)),
            ...$materials,
            $end,
        ];

        return new self($language, [$level], $steps, [$level->id => $levelProgress]);
    }

    /**
     * The first level as a new learner sees it, for the homepage.
     */
    public static function preview(Language $language): self
    {
        return self::forLevel($language, $language->firstLevel(), new LearnerProgress($language));
    }

    /**
     * A level's lessons, then its practice.
     */
    private static function materials(Language $language, Level $level, LearnerProgress $progress): array
    {
        $steps = [];

        foreach ($level->lessons as $index => $lesson) {
            $open = $progress->isLessonOpen($lesson);
            $steps[] = self::step(
                type: 'lesson',
                kind: 'Pelajaran '.($index + 1),
                title: $lesson->title,
                meta: '+'.$lesson->xp.' XP',
                icon: 'book-open',
                url: $open ? route('lessons.show', [$language->key, $level->order, $lesson->order]) : null,
                done: $progress->isLessonDone($lesson),
                locked: ! $open,
            );
        }

        if ($level->questions !== []) {
            $open = $progress->isPracticeOpen($level);
            $steps[] = self::step(
                type: 'practice',
                kind: 'Latihan',
                title: count($level->questions).' soal latihan',
                meta: '+'.$level->questionXp().' XP · '.$level->questionTypeCount().' jenis soal',
                icon: 'circle-question',
                url: $open ? route('practice.show', [$language->key, $level->order, 1]) : null,
                done: $progress->isPracticeDone($level),
                locked: ! $open,
            );
        }

        return $steps;
    }

    /**
     * @param  list<array>  $materials  the level's lesson and practice steps
     */
    private static function levelProgress(array $materials, ?string $url): array
    {
        $done = count(array_filter(array_column($materials, 'done')));
        $total = count($materials);

        return [
            'done' => $done,
            'total' => $total,
            'percent' => intdiv($done * 100, $total),
            'finished' => $done === $total,
            'url' => $url,
            'action' => match ($done) {
                0 => 'Mulai',
                $total => 'Ulangi',
                default => 'Lanjutkan',
            },
            'locked' => $url === null,
            'next' => false,
        ];
    }

    private static function levelStep(Level $level, ?string $url, bool $done, bool $locked): array
    {
        return self::step(
            type: 'level',
            kind: 'Level '.$level->order,
            title: $level->title,
            meta: count($level->lessons).' pelajaran · '.count($level->questions).' soal · '.$level->totalXp().' XP',
            icon: 'flag',
            url: $url,
            done: $done,
            locked: $locked,
        );
    }

    private static function comingSoon(Level $last): array
    {
        return self::step(
            type: 'soon',
            kind: 'Level '.($last->order + 1),
            title: 'Segera hadir',
            meta: 'Materinya sedang kami siapkan',
            icon: 'lock',
            url: null,
            done: false,
            locked: true,
        );
    }

    private static function step(string $type, string $kind, string $title, string $meta, string $icon, ?string $url, bool $done, bool $locked): array
    {
        return [
            'type' => $type,
            'kind' => $kind,
            'title' => $title,
            'meta' => $meta,
            // A finished level's flag becomes a trophy; locked levels keep their flag, greyed out.
            'icon' => match (true) {
                $done => $type === 'level' ? 'trophy' : 'check',
                $locked && $type !== 'level' => 'lock',
                default => $icon,
            },
            'url' => $url,
            'done' => $done,
            'locked' => $locked,
            'current' => false,
            'badge' => null,
        ];
    }

    /**
     * SVG path from the first node to the node at $last.
     */
    private function buildLine(int $last): string
    {
        $line = '';

        foreach (array_slice($this->steps, 0, $last + 1) as $index => $step) {
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
