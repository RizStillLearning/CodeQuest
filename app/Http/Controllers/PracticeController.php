<?php

namespace App\Http\Controllers;

use App\Content\Language;
use App\Content\Level;
use App\Models\Completion;
use App\Progress\LearnerProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * A level's practice questions, one per page. Answers are checked here, never in
 * the browser, and each one is saved as soon as it's given. The practice is done,
 * and the next level unlocks, once every question is answered with at least the
 * level's minimum score.
 */
class PracticeController extends Controller
{
    public function show(Request $request, Language $language, Level $level, int $number): View
    {
        $question = $level->questions[$number - 1] ?? abort(404);
        $this->ensureUnlocked(LearnerProgress::of($request->user(), $language)->isPracticeOpen($level), $language);

        $total = count($level->questions);
        $isLast = $number === $total;

        return view('practice.show', [
            'language' => $language,
            'level' => $level,
            'question' => $question,
            'number' => $number,
            'progressLabel' => "Soal {$number} dari {$total}",
            'progress' => intdiv($number * 100, $total),
            'attempt' => $request->user()->answers()->where('question_id', $question->id)->first(),
            'nextUrl' => $isLast
                ? route('practice.results', [$language->key, $level->order])
                : route('practice.show', [$language->key, $level->order, $number + 1]),
            'nextLabel' => $isLast ? 'Lihat hasil' : 'Soal berikutnya',
        ]);
    }

    public function answer(Request $request, Language $language, Level $level, int $number): RedirectResponse
    {
        $question = $level->questions[$number - 1] ?? abort(404);
        $user = $request->user();
        $this->ensureUnlocked(LearnerProgress::of($user, $language)->isPracticeOpen($level), $language);

        // The first answer counts: a resubmitted form (Back button, double click) doesn't replace it.
        if (! $user->answers()->where('question_id', $question->id)->exists()) {
            $answer = $request->validate([
                'answer' => $question->type->hasOptions()
                    ? ['required', 'string', Rule::in($question->options)]
                    : ['required', 'string', 'max:1000'],
            ])['answer'];

            $user->answers()->create([
                'question_id' => $question->id,
                'answer' => $answer,
                'correct' => $question->isCorrect($answer),
            ]);

            $results = $user->answers()->whereIn('question_id', $level->questionIds())->pluck('correct');

            if ($results->count() === count($level->questions) && $results->filter()->count() >= $level->requiredCorrect()) {
                $user->completions()->firstOrCreate(['type' => Completion::PRACTICE, 'content_id' => $level->id]);
            }
        }

        return redirect()->route('practice.show', [$language->key, $level->order, $number]);
    }

    public function results(Request $request, Language $language, Level $level): View
    {
        $progress = LearnerProgress::of($request->user(), $language);
        $this->ensureUnlocked($progress->isPracticeOpen($level), $language);

        $answers = $request->user()->answers()->whereIn('question_id', $level->questionIds())->get()->keyBy('question_id');
        $review = [];

        foreach ($level->questions as $index => $question) {
            $review[] = [
                'number' => $index + 1,
                'type' => $question->type,
                'prompt' => $question->prompt,
                'state' => match ($answers->get($question->id)?->correct) {
                    true => 'correct',
                    false => 'wrong',
                    null => 'unanswered',
                },
                'url' => route('practice.show', [$language->key, $level->order, $index + 1]),
            ];
        }

        $states = array_column($review, 'state');
        $correct = count(array_keys($states, 'correct', true));
        $unanswered = count(array_keys($states, 'unanswered', true));
        $nextLevel = $language->levelAfter($level);

        return view('practice.results', [
            'language' => $language,
            'level' => $level,
            'review' => $review,
            'total' => count($review),
            'correct' => $correct,
            'unanswered' => $unanswered,
            'required' => $level->requiredCorrect(),
            'failed' => $unanswered === 0 && $correct < $level->requiredCorrect(),
            // Shown once the next level is unlocked, which also covers a pass in an earlier run.
            'nextLevel' => $nextLevel && $progress->isLevelOpen($nextLevel) ? $nextLevel : null,
            'nextLevelUrl' => $nextLevel ? route('levels.show', [$language->key, $nextLevel->order]) : null,
        ]);
    }

    /**
     * Starts a fresh run. The level's practice stays completed.
     */
    public function restart(Request $request, Language $language, Level $level): RedirectResponse
    {
        $this->ensureUnlocked(LearnerProgress::of($request->user(), $language)->isPracticeOpen($level), $language);

        $request->user()->answers()->whereIn('question_id', $level->questionIds())->delete();

        return redirect()->route('practice.show', [$language->key, $level->order, 1]);
    }
}
