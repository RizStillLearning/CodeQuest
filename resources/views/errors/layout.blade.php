{{--
    Shared error page, rendered by Laravel's exception handler (not a controller).
    Error views use:
        @extends('errors.layout')
        @section('code', '404')
        @section('icon', 'road-sign')             (pixelarticons name)
        @section('title', '...')
        @section('message', '...')
        @section('retry', true)                   (optional: shows "Coba lagi")
--}}
@extends('layouts.minimal')

@section('content')
    <section class="cq-message">
        <span class="cq-icon-tile is-xp mx-auto" aria-hidden="true"><i class="pixelart-icons-font-@yield('icon', 'warning-diamond')"></i></span>
        <p class="cq-error-code">Kode @yield('code')</p>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @hasSection('retry')
                {{-- "Try again" repeats a GET; after a failed form submit it goes back to the form. --}}
                <a href="{{ request()->isMethod('GET') ? url()->current() : url()->previous() }}" class="btn btn-primary">
                    <i class="pixelart-icons-font-reload" aria-hidden="true"></i> Coba lagi
                </a>
                <a href="{{ url('/') }}" class="btn btn-ghost">Kembali ke beranda</a>
            @else
                <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke beranda</a>
            @endif
        </div>
    </section>
@endsection
