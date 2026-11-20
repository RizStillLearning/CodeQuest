{{-- Data comes from LearnController. The signed-in home: pick a language, follow its path. --}}
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

            @include('partials.language-tracks', ['paths' => $paths, 'startUrl' => null])
        </div>
    </section>
@endsection
