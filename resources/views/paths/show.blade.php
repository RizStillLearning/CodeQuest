{{-- Data comes from PathController. --}}
@extends('layouts.app')

@section('title', 'Jalur belajar '.$path->language->name.' · CodeQuest')

@section('content')
    <section class="cq-page" aria-labelledby="cq-path-title">
        <div class="container">
            <a href="{{ route('learn') }}" class="cq-back-link">
                <i class="pixelart-icons-font-arrow-left" aria-hidden="true"></i> Pilih bahasa
            </a>

            <div class="cq-path-page-head">
                <span class="cq-lang-badge cq-lang-{{ $path->language->key }}" aria-hidden="true">.{{ $path->language->extension() }}</span>
                <div>
                    <h1 id="cq-path-title">{{ $path->language->name }}</h1>
                    <p class="text-body-secondary mb-0">{{ $path->language->tagline }}</p>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-5 cq-sticky-lg">
                    <div class="cq-lang-card cq-level-list">
                        @foreach ($path->levels as $level)
                            @include('partials.level-summary', ['level' => $level])
                            @include('partials.level-progress', ['level' => $level, 'progress' => $path->levelProgress[$level->id]])
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7">
                    @include('partials.path-panel', ['path' => $path, 'title' => 'Jalur level'])
                </div>
            </div>
        </div>
    </section>
@endsection
