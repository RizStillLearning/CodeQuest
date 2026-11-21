<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Leaderboard (a "later" feature in CLAUDE.md). Not built yet: shows a "being built" page.
 */
class LeaderboardController extends Controller
{
    public function __invoke(): View
    {
        return view('coming-soon', [
            'title' => 'Papan peringkat',
            'icon' => 'trophy',
            'description' => 'Di sini kamu akan bisa melihat posisimu dibanding pelajar lain berdasarkan XP.',
        ]);
    }
}
