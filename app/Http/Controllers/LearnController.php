<?php

namespace App\Http\Controllers;

use App\Content\ContentException;
use App\Content\ContentRepository;
use App\ViewModels\LearningPath;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The signed-in home: pick a language and see its learning path.
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

        return view('learn', [
            'user' => $request->user(),
            'paths' => array_map(LearningPath::forLanguage(...), array_values($languages)),
        ]);
    }
}
