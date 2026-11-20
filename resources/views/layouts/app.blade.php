{{--
    Main layout. Pages use:
        @extends('layouts.app')
        @section('title', 'Judul · CodeQuest')
        @section('description', '...')   (optional)
        @section('content') ... @endsection
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', 'CodeQuest: belajar dasar pemrograman lewat pelajaran singkat, soal interaktif, XP, dan level. Mulai dari nol dengan Python, Java, atau C.')">
    <meta name="theme-color" content="#5b4bdb">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="cq-app">
    <a class="visually-hidden-focusable cq-skip-link" href="#konten">Langsung ke konten utama</a>

    @include('partials.navbar')

    @if (session('status'))
        <div class="cq-toast-region">
            <div class="toast show cq-toast" role="status" aria-live="polite" aria-atomic="true" data-autohide-toast>
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill" aria-hidden="true"></i>
                    <div class="toast-body">{{ session('status') }}</div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                </div>
            </div>
        </div>
    @endif

    <main id="konten">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
