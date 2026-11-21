{{-- Data comes from the feature's controller (e.g. LeaderboardController) until the feature is built. --}}
@extends('layouts.app')

@section('title', $title.' · CodeQuest')

@section('content')
    <section class="cq-page">
        <div class="container">
            <div class="cq-message">
                <span class="cq-icon-tile mx-auto" aria-hidden="true"><i class="pixelart-icons-font-{{ $icon }}"></i></span>
                <span class="cq-chip cq-chip-xp mb-3"><i class="pixelart-icons-font-hourglass" aria-hidden="true"></i> Segera hadir</span>
                <h1>{{ $title }}</h1>
                <p>{{ $description }} Fitur ini sedang kami bangun. Sementara itu, lanjutkan belajar dan kumpulkan XP.</p>
                <a href="{{ route('learn') }}" class="btn btn-primary">
                    <i class="pixelart-icons-font-arrow-left" aria-hidden="true"></i> Kembali belajar
                </a>
            </div>
        </div>
    </section>
@endsection
