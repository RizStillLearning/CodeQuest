{{--
    Login and register pages: the form card on the left, the "why an account" panel on the right.
    Pages use:
        @extends('layouts.auth')
        @section('title', 'Masuk · CodeQuest')
        @section('heading', 'Masuk ke CodeQuest')
        @section('subheading', '...')
        @section('form') ... @endsection
--}}
@extends('layouts.app')

@section('content')
    <section class="cq-auth">
        <div class="container">
            <div class="cq-auth-shell">
                <div class="cq-auth-card">
                    <h1 class="cq-auth-title">@yield('heading')</h1>
                    <p class="cq-auth-subtitle">@yield('subheading')</p>
                    @yield('form')
                </div>

                <aside class="cq-auth-aside" aria-labelledby="cq-auth-aside-title">
                    <span class="cq-kicker">Dengan akun CodeQuest</span>
                    <h2 id="cq-auth-aside-title">Belajarmu tersimpan, langkahmu jelas.</h2>
                    <ul class="cq-auth-perks">
                        <li>
                            <span class="cq-perk-icon is-xp" aria-hidden="true"><i class="bi bi-lightning-charge-fill"></i></span>
                            <div><strong>XP yang terus bertambah</strong><span>Setiap pelajaran dan soal yang selesai menambah XP-mu.</span></div>
                        </li>
                        <li>
                            <span class="cq-perk-icon" aria-hidden="true"><i class="bi bi-signpost-split-fill"></i></span>
                            <div><strong>Jalur level demi level</strong><span>Selesaikan satu level untuk membuka level berikutnya.</span></div>
                        </li>
                        <li>
                            <span class="cq-perk-icon" aria-hidden="true"><i class="bi bi-bookmark-check-fill"></i></span>
                            <div><strong>Lanjut kapan saja</strong><span>Progresmu tersimpan setelah setiap soal.</span></div>
                        </li>
                    </ul>
                    <div class="cq-mini-path" aria-hidden="true">
                        <span class="cq-mini-node is-done"><i class="bi bi-check-lg"></i></span>
                        <span class="cq-mini-link"></span>
                        <span class="cq-mini-node is-open"><i class="bi bi-play-fill"></i></span>
                        <span class="cq-mini-link"></span>
                        <span class="cq-mini-node"><i class="bi bi-lock-fill"></i></span>
                        <span class="cq-mini-link"></span>
                        <span class="cq-mini-node"><i class="bi bi-trophy-fill"></i></span>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
