<?php

namespace App\Providers;

use App\Content\ContentRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(ContentRepository::class, fn () => new ContentRepository(
            base_path('content'),
            config('codequest.languages'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kept simple for beginners: at least 8 characters.
        Password::defaults(fn () => Password::min(8));
    }
}
