<?php

namespace Tests\Feature;

use Illuminate\Routing\Route as RouteDefinition;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * Project convention: every page goes through a controller in
     * App\Http\Controllers (no closures, no Route::view).
     */
    public function test_every_app_route_uses_an_app_controller(): void
    {
        $appRoutes = array_filter(
            Route::getRoutes()->getRoutes(),
            fn (RouteDefinition $route) => ! $this->isFrameworkRoute($route),
        );

        $this->assertNotEmpty($appRoutes);

        foreach ($appRoutes as $route) {
            $controller = $route->getAction('controller');

            $this->assertIsString($controller, "Route /{$route->uri()} is a closure; give it a controller.");
            $this->assertStringStartsWith(
                'App\\Http\\Controllers\\',
                $controller,
                "Route /{$route->uri()} uses {$controller}; give it a controller in App\\Http\\Controllers.",
            );
        }
    }

    private function isFrameworkRoute(RouteDefinition $route): bool
    {
        // Laravel's health check (/up) and local file serving (storage.local*).
        return $route->uri() === 'up' || str_starts_with((string) $route->getName(), 'storage.');
    }
}
