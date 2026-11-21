{{-- Data comes from LevelController. --}}
@extends('layouts.app')

@section('title', 'Level '.$level->order.' '.$path->language->name.' · CodeQuest')

@section('content')
    <section class="cq-page" aria-labelledby="cq-level-title">
        <div class="container">
            <a href="{{ route('paths.show', $path->language->key) }}" class="cq-back-link">
                <i class="pixelart-icons-font-arrow-left" aria-hidden="true"></i> Semua level
            </a>

            <div class="cq-path-page-head">
                <span class="cq-lang-badge cq-lang-{{ $path->language->key }}" aria-hidden="true">.{{ $path->language->extension() }}</span>
                <div>
                    <span class="cq-level-header-kicker">{{ $path->language->name }} · Level {{ $level->order }}</span>
                    <h1 id="cq-level-title">{{ $level->title }}</h1>
                    <p class="text-body-secondary mb-0">{{ $level->description }}</p>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-5 cq-sticky-lg">
                    <div class="cq-lang-card cq-level-list">
                        <ul class="cq-stats">
                            <li><i class="pixelart-icons-font-book-open" aria-hidden="true"></i> <strong>{{ count($level->lessons) }}</strong> pelajaran</li>
                            <li><i class="pixelart-icons-font-circle-question" aria-hidden="true"></i> <strong>{{ count($level->questions) }}</strong> soal</li>
                            <li><i class="pixelart-icons-font-zap" aria-hidden="true"></i> <strong>{{ $level->totalXp() }}</strong> XP</li>
                        </ul>
                        @include('partials.level-progress', ['level' => $level, 'progress' => $path->levelProgress[$level->id]])
                        @if ($level->questions !== [])
                            <p class="cq-pass-note">
                                <i class="pixelart-icons-font-flag" aria-hidden="true"></i>
                                Jawab benar minimal {{ $level->requiredCorrect() }} dari {{ count($level->questions) }} soal latihan untuk menyelesaikan level ini.
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    @include('partials.path-panel', ['path' => $path, 'title' => 'Materi level '.$level->order])
                </div>
            </div>
        </div>
    </section>
@endsection
