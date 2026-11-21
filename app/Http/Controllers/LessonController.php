<?php

namespace App\Http\Controllers;

use App\Content\Language;
use App\Content\Level;
use App\Models\Completion;
use App\Progress\LearnerProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function __invoke(Request $request, Language $language, Level $level, int $lesson): View
    {
        $current = $level->lesson($lesson) ?? abort(404);

        $this->ensureUnlocked(LearnerProgress::of($request->user(), $language)->isLessonOpen($current), $language);

        // Opening a lesson completes it.
        $request->user()->completions()->firstOrCreate(['type' => Completion::LESSON, 'content_id' => $current->id]);

        $index = array_search($current, $level->lessons, true);
        $previous = $level->lessons[$index - 1] ?? null;
        $next = $level->lessons[$index + 1] ?? null;

        if ($next) {
            $nextUrl = route('lessons.show', [$language->key, $level->order, $next->order]);
            $nextLabel = 'Lanjut: '.$next->title;
        } elseif ($level->questions !== []) {
            $nextUrl = route('practice.show', [$language->key, $level->order, 1]);
            $nextLabel = 'Mulai latihan soal';
        } else {
            $nextUrl = route('levels.show', [$language->key, $level->order]);
            $nextLabel = 'Kembali ke materi level';
        }

        return view('lessons.show', [
            'language' => $language,
            'level' => $level,
            'lesson' => $current,
            'progressLabel' => 'Pelajaran '.($index + 1).' dari '.count($level->lessons),
            'progress' => intdiv(($index + 1) * 100, count($level->lessons)),
            // Lesson files are our own content, but raw HTML in them is still never rendered.
            'body' => Str::markdown($current->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]),
            'previousUrl' => $previous ? route('lessons.show', [$language->key, $level->order, $previous->order]) : null,
            'nextUrl' => $nextUrl,
            'nextLabel' => $nextLabel,
        ]);
    }
}
