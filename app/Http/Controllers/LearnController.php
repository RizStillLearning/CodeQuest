<?php

namespace App\Http\Controllers;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\Progress\LearnerProgress;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The signed-in home: pick a language. Each card shows the level the learner is
 * on in that language; the language's path is on PathController's page.
 */
class LearnController extends Controller
{
    public function __invoke(Request $request, ContentRepository $content): View
    {
        try {
            $languages = $content->languages();
        } catch (ContentException $e) {
            report($e);

            $languages = [];
        }

        $progress = [];

        foreach ($languages as $language) {
            $progress[$language->key] = LearnerProgress::of($request->user(), $language);
        }

        return view('learn', [
            'user' => $request->user(),
            'languages' => array_values($languages),
            'progress' => $progress,
        ]);
    }
}
