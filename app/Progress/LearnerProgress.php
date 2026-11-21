<?php

namespace App\Progress;

use App\Content\Language;
use App\Content\Lesson;
use App\Content\Level;
use App\Models\Completion;
use App\Models\User;

/**
 * What a learner has finished in one language, and what they may open.
 *
 * Steps unlock in order: a level's lessons, then its practice, then the next
 * level. A step is open when it's done or when it's the first one that isn't,
 * so nothing can be skipped and finished steps stay open for review.
 */
final class LearnerProgress
{
    /** @var array<string, true> lesson id => true */
    private array $lessonsDone;

    /** @var array<string, true> level id => true */
    private array $practicesDone;

    private ?string $nextLessonId = null;

    /** The level whose practice is next, when the next step is a practice. */
    private ?string $nextPracticeId = null;

    private Level $currentLevel;

    /**
     * @param  list<string>  $completedLessons  lesson ids
     * @param  list<string>  $completedPractices  ids of levels whose practice is passed
     */
    public function __construct(private readonly Language $language, array $completedLessons = [], array $completedPractices = [])
    {
        $this->lessonsDone = array_fill_keys($completedLessons, true);
        $this->practicesDone = array_fill_keys($completedPractices, true);
        $this->findNextStep();
    }

    public static function of(User $user, Language $language): self
    {
        $completions = $user->completions()->get(['type', 'content_id']);

        return new self(
            $language,
            $completions->where('type', Completion::LESSON)->pluck('content_id')->all(),
            $completions->where('type', Completion::PRACTICE)->pluck('content_id')->all(),
        );
    }

    public function isLessonDone(Lesson $lesson): bool
    {
        return isset($this->lessonsDone[$lesson->id]);
    }

    public function isPracticeDone(Level $level): bool
    {
        return isset($this->practicesDone[$level->id]);
    }

    public function isLessonOpen(Lesson $lesson): bool
    {
        return $this->isLessonDone($lesson) || $this->nextLessonId === $lesson->id;
    }

    public function isPracticeOpen(Level $level): bool
    {
        return $this->isPracticeDone($level) || $this->nextPracticeId === $level->id;
    }

    /**
     * The level the learner is working on: the one holding their next step, or
     * the last level once they've finished everything.
     */
    public function currentLevel(): Level
    {
        return $this->currentLevel;
    }

    /**
     * Whether the learner has finished any lesson or practice in this language.
     */
    public function hasStarted(): bool
    {
        foreach ($this->language->levels as $level) {
            if ($this->isPracticeDone($level)) {
                return true;
            }

            foreach ($level->lessons as $lesson) {
                if ($this->isLessonDone($lesson)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isLevelDone(Level $level): bool
    {
        foreach ($level->lessons as $lesson) {
            if (! $this->isLessonDone($lesson)) {
                return false;
            }
        }

        return $level->questions === [] || $this->isPracticeDone($level);
    }

    /**
     * A level is open once any of its steps is: the learner reached it, or finished part of it before.
     */
    public function isLevelOpen(Level $level): bool
    {
        foreach ($level->lessons as $lesson) {
            if ($this->isLessonOpen($lesson)) {
                return true;
            }
        }

        return $level->questions !== [] && $this->isPracticeOpen($level);
    }

    private function findNextStep(): void
    {
        foreach ($this->language->levels as $level) {
            // Left on the last level when every step is done.
            $this->currentLevel = $level;

            foreach ($level->lessons as $lesson) {
                if (! $this->isLessonDone($lesson)) {
                    $this->nextLessonId = $lesson->id;

                    return;
                }
            }

            if ($level->questions !== [] && ! $this->isPracticeDone($level)) {
                $this->nextPracticeId = $level->id;

                return;
            }
        }
    }
}
