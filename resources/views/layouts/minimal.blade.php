{{--
    Layout for error pages. It must not touch the database, session, or auth,
    because it renders while those may be the thing that failed.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title') · CodeQuest</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|jetbrains-mono:400,500&display=swap">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif
</head>
<body class="cq-minimal">
    <header class="cq-minimal-header">
        <a href="{{ url('/') }}" aria-label="CodeQuest, ke beranda">@include('partials.logo')</a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
