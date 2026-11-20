<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Signed-in users who open /login or /register go straight to learning.
        $middleware->redirectUsersTo(fn () => route('learn'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // A form left open past the session lifetime fails the CSRF check (419).
        // Send the user back to the form, keeping what they typed, instead of
        // showing an error page.
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($e->getStatusCode() !== 419 || $request->expectsJson()) {
                return null;
            }

            return redirect()->back()
                ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                ->with('status', 'Halaman ini sudah terlalu lama dibuka. Silakan kirim ulang formulirnya.');
        });
    })->create();
