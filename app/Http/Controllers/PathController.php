<?php

namespace App\Http\Controllers;

use App\Content\Language;
use App\Progress\LearnerProgress;
use App\ViewModels\LearningPath;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * One language's learning path, with the learner's finished steps marked and
 * the steps they haven't reached yet locked.
 */
class PathController extends Controller
{
    public function __invoke(Request $request, Language $language): View
    {
        return view('paths.show', [
            'path' => LearningPath::forLanguage($language, LearnerProgress::of($request->user(), $language)),
        ]);
    }
}
