<?php

namespace App\Providers;

use App\Content\ContentRepository;
use Illuminate\Routing\Route as RouteDefinition;
use Illuminate\Support\Facades\Route;
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

        // /belajar/{language}/{level}/...: the language key and the level's order number.
        Route::bind('language', fn (string $key) => $this->app->make(ContentRepository::class)->languages()[$key] ?? abort(404));
        Route::bind('level', fn (string $order, RouteDefinition $route) => $route->parameter('language')->level((int) $order) ?? abort(404));
    }
}
