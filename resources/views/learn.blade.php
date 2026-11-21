{{-- Data comes from LearnController. The signed-in home: pick a language. --}}
@extends('layouts.app')

@section('title', 'Belajar · CodeQuest')

@section('content')
    <section class="cq-page" aria-labelledby="cq-learn-title">
        <div class="container">
            <div class="cq-section-head">
                <span class="cq-kicker">Halo, {{ $user->firstName() }}!</span>
                <h1 id="cq-learn-title">Pilih bahasamu, ikuti jalurnya</h1>
                <p>Setiap bahasa punya jalur belajarnya sendiri. Level 1 dimulai dari nol, jadi kamu tidak perlu pengalaman coding sebelumnya.</p>
            </div>

            @if ($languages === [])
                @include('partials.content-notice')
            @else
                <div class="row g-4">
                    @foreach ($languages as $language)
                        <div class="col-md-6 col-lg-4">
                            <div class="cq-lang-card h-100 d-flex flex-column">
                                @include('partials.language-summary', ['language' => $language])
                                @include('partials.level-summary', ['level' => $language->firstLevel()])
                                <a href="{{ route('paths.show', $language->key) }}" class="btn btn-primary w-100 mt-auto">
                                    Mulai belajar {{ $language->name }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
