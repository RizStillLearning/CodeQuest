<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Discussion / Q&A forum (a "later" feature in CLAUDE.md). Not built yet: shows a "being built" page.
 */
class ForumController extends Controller
{
    public function __invoke(): View
    {
        return view('coming-soon', [
            'title' => 'Forum diskusi',
            'icon' => 'message',
            'description' => 'Di sini kamu akan bisa bertanya seputar materi dan soal, dan membantu menjawab pertanyaan pelajar lain.',
        ]);
    }
}
