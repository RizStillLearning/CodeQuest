<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Completion extends Model
{
    /** content_id is a lesson id. */
    public const LESSON = 'lesson';

    /** content_id is a level id: every practice question of the level was answered. */
    public const PRACTICE = 'practice';

    protected $fillable = ['type', 'content_id'];
}
