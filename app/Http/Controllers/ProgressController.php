<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Progress tracking (MVP step 5). Not built yet: shows a "being built" page.
 */
class ProgressController extends Controller
{
    public function __invoke(): View
    {
        return view('coming-soon', [
            'title' => 'Progres belajar',
            'icon' => 'trending-up',
            'description' => 'Di sini kamu akan bisa melihat level yang sudah selesai, XP yang terkumpul, dan soal yang perlu diulang.',
        ]);
    }
}
