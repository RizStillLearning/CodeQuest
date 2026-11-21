<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * What a learner has finished: a lesson (by lesson id) or a level's
     * practice (by level id). Ids come from content/ and never change.
     */
    public function up(): void
    {
        Schema::create('completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->string('content_id', 100);
            $table->timestamps();

            $table->unique(['user_id', 'type', 'content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('completions');
    }
};
