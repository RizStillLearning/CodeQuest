<?php

namespace App\Http\Controllers;

use App\Content\Language;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Controller
{
    /**
     * Lessons and practice unlock in order (see LearnerProgress). A learner who
     * opens a locked one, from an old link or a typed URL, goes back to the path.
     */
    protected function ensureUnlocked(bool $unlocked, Language $language): void
    {
        if (! $unlocked) {
            throw new HttpResponseException(
                redirect()->route('paths.show', $language->key)
                    ->with('status', 'Materi itu masih terkunci. Selesaikan langkah sebelumnya dulu, ya.'),
            );
        }
    }
}
