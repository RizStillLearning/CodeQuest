{{-- Data comes from LessonController. --}}
@extends('layouts.app')

@section('title', $lesson->title.' · CodeQuest')

@section('content')
    <section class="cq-page cq-study">
        <div class="container cq-study-container">
            @include('partials.level-header', ['language' => $language, 'level' => $level, 'label' => $progressLabel, 'progress' => $progress])

            <article class="cq-study-card" aria-labelledby="cq-lesson-title">
                <h1 class="cq-study-title" id="cq-lesson-title">{{ $lesson->title }}</h1>
                <div class="cq-lesson-body">
                    {!! $body !!}
                </div>
            </article>

            <nav class="cq-study-nav" aria-label="Navigasi pelajaran">
                @if ($previousUrl)
                    <a href="{{ $previousUrl }}" class="btn btn-ghost">
                        <i class="pixelart-icons-font-arrow-left" aria-hidden="true"></i> Sebelumnya
                    </a>
                @endif
                <a href="{{ $nextUrl }}" class="btn btn-primary ms-auto">
                    {{ $nextLabel }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                </a>
            </nav>
        </div>
    </section>
@endsection
