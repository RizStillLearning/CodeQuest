{{-- Data comes from HomeController. Guests only: signed-in users land on /belajar. --}}
@extends('layouts.app')

@section('title', 'CodeQuest · Belajar Coding Lewat Praktik')

@section('content')

    {{-- Hero --}}
    <section class="cq-hero" aria-labelledby="cq-hero-title">
        <div class="container">
            <div class="row align-items-center gy-5 gx-lg-5">
                <div class="col-lg-6">
                    <span class="cq-eyebrow">
                        <i class="bi bi-controller" aria-hidden="true"></i> Belajar coding ala game
                    </span>
                    <h1 class="cq-hero-title" id="cq-hero-title">
                        Belajar coding lewat <span class="cq-highlight">praktik</span>, bukan hafalan.
                    </h1>
                    <p class="cq-lead">
                        Pelajaran singkat, soal interaktif, dan XP di setiap langkah.
                        Pilih bahasa, selesaikan level demi level, dan lihat progresmu terus naik.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            Mulai belajar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="#cara-kerja" class="btn btn-ghost btn-lg">Lihat cara kerjanya</a>
                    </div>
                    <ul class="cq-checks">
                        <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Mulai dari nol</li>
                        <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Feedback di setiap jawaban</li>
                        <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Progres tersimpan otomatis</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    @if ($demoQuestion)
                        @include('partials.home.try-question', ['question' => $demoQuestion, 'language' => $demoLanguage])
                    @else
                        @include('partials.home.hero-art')
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Why CodeQuest: one card per top learner problem from the survey --}}
    <section class="cq-section" id="kenapa" aria-labelledby="cq-why-title">
        <div class="container">
            <div class="cq-section-head">
                <span class="cq-kicker">Kenapa CodeQuest</span>
                <h2 id="cq-why-title">Belajar coding tidak harus membosankan</h2>
                <p>CodeQuest dirancang untuk tiga hal yang paling sering membuat orang berhenti belajar coding.</p>
            </div>

            <div class="row g-4">
                @foreach ($reasons as $reason)
                    <div class="col-md-4">
                        <div class="cq-card">
                            <span class="cq-icon-tile is-{{ $reason['tone'] }}" aria-hidden="true">
                                <i class="bi bi-{{ $reason['icon'] }}"></i>
                            </span>
                            <p class="cq-problem">
                                <i class="bi bi-chat-quote-fill" aria-hidden="true"></i>
                                <span><span class="visually-hidden">Masalah: </span>&ldquo;{{ $reason['problem'] }}&rdquo;</span>
                            </p>
                            <h3>{{ $reason['title'] }}</h3>
                            <p>{{ $reason['body'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="cq-section cq-section-surface" id="cara-kerja" aria-labelledby="cq-how-title">
        <div class="container">
            <div class="cq-section-head">
                <span class="cq-kicker">Cara kerja</span>
                <h2 id="cq-how-title">Lima langkah dari nol sampai naik level</h2>
                <p>Alurnya sederhana, jadi kamu bisa fokus belajar.</p>
            </div>

            <ol class="cq-steps">
                @foreach ($steps as $step)
                    <li class="cq-step">
                        <span class="cq-step-node" aria-hidden="true"><i class="bi bi-{{ $step['icon'] }}"></i></span>
                        <div>
                            <span class="cq-step-number">Langkah {{ $loop->iteration }}</span>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['body'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Languages and their learning paths --}}
    <section class="cq-section" id="bahasa" aria-labelledby="cq-lang-title">
        <div class="container">
            <div class="cq-section-head">
                <span class="cq-kicker">Bahasa</span>
                <h2 id="cq-lang-title">Pilih bahasamu, ikuti jalurnya</h2>
                <p>Setiap bahasa punya jalur belajarnya sendiri. Level 1 dimulai dari nol, jadi kamu tidak perlu pengalaman coding sebelumnya.</p>
            </div>

            @include('partials.language-tracks', ['tracks' => $tracks, 'paths' => $paths, 'startUrl' => route('register')])
        </div>
    </section>

    {{-- Question types --}}
    <section class="cq-section cq-section-surface" id="jenis-soal" aria-labelledby="cq-types-title">
        <div class="container">
            <div class="cq-section-head">
                <span class="cq-kicker">Latihan</span>
                <h2 id="cq-types-title">Empat jenis soal, biar tidak monoton</h2>
                <p>Setiap level mencampur jenis soal. Benar atau salah, kamu langsung dapat penjelasannya.</p>
            </div>

            <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-xl-4">
                @foreach ($questionTypes as $questionType)
                    <div class="col">
                        <div class="cq-card cq-type-card">
                            <span class="cq-icon-tile" aria-hidden="true"><i class="bi bi-{{ $questionType['type']->icon() }}"></i></span>
                            <h3>{{ $questionType['type']->label() }}</h3>
                            <p>{{ $questionType['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final call to action --}}
    <section class="cq-section" aria-labelledby="cq-cta-title">
        <div class="container">
            <div class="cq-cta">
                <div>
                    <h2 id="cq-cta-title">Siap memulai quest pertamamu?</h2>
                    <p>Level 1 dimulai dari nol. Tidak perlu pengalaman coding sebelumnya.</p>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn btn-xp btn-lg">Daftar sekarang</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Masuk</a>
                </div>
            </div>
        </div>
    </section>

@endsection
