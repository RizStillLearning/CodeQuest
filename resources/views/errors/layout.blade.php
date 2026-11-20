{{--
    Shared error page, rendered by Laravel's exception handler (not a controller).
    Error views use:
        @extends('errors.layout')
        @section('code', '404')
        @section('icon', 'signpost-split-fill')   (Bootstrap Icons name)
        @section('title', '...')
        @section('message', '...')
        @section('retry', true)                   (optional: shows "Coba lagi")
--}}
@extends('layouts.minimal')

@section('content')
    <section class="cq-message">
        <span class="cq-icon-tile is-xp mx-auto" aria-hidden="true"><i class="bi bi-@yield('icon', 'exclamation-triangle-fill')"></i></span>
        <p class="cq-error-code">Kode @yield('code')</p>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @hasSection('retry')
                {{-- "Try again" repeats a GET; after a failed form submit it goes back to the form. --}}
                <a href="{{ request()->isMethod('GET') ? url()->current() : url()->previous() }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise" aria-hidden="true"></i> Coba lagi
                </a>
                <a href="{{ url('/') }}" class="btn btn-ghost">Kembali ke beranda</a>
            @else
                <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke beranda</a>
            @endif
        </div>
    </section>
@endsection
