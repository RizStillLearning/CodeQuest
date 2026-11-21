<?php

namespace App\Http\Controllers;

use App\Content\Language;
use App\Content\Level;
use App\Progress\LearnerProgress;
use App\ViewModels\LearningPath;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * One level's lessons and practice as a path, opened from the level's node on
 * the language path.
 */
class LevelController extends Controller
{
    public function __invoke(Request $request, Language $language, Level $level): View
    {
        $progress = LearnerProgress::of($request->user(), $language);
        $this->ensureUnlocked($progress->isLevelOpen($level), $language);

        return view('levels.show', [
            'level' => $level,
            'path' => LearningPath::forLevel($language, $level, $progress),
        ]);
    }
}
