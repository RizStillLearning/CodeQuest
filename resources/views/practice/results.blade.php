{{-- Data comes from PracticeController@results. --}}
@extends('layouts.app')

@section('title', 'Hasil latihan · CodeQuest')

@section('content')
    <section class="cq-page cq-study">
        <div class="container cq-study-container">
            @include('partials.level-header', ['language' => $language, 'level' => $level, 'label' => 'Hasil latihan', 'progress' => 100])

            <article class="cq-study-card" aria-labelledby="cq-results-title">
                @if ($unanswered === $total)
                    <h1 class="cq-study-title" id="cq-results-title">Belum ada soal yang dijawab</h1>
                    <p class="text-body-secondary">Kerjakan latihan soalnya dulu, lalu hasilmu muncul di sini.</p>
                    <a href="{{ route('practice.show', [$language->key, $level->order, 1]) }}" class="btn btn-primary">
                        Mulai latihan <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                    </a>
                @else
                    <span class="cq-kicker">Hasil latihan</span>
                    <h1 class="cq-study-title" id="cq-results-title">{{ $correct }} dari {{ $total }} soal benar</h1>
                    <p class="text-body-secondary">
                        @if ($correct === $total)
                            Sempurna! Semua jawabanmu benar.
                        @elseif ($unanswered > 0)
                            Masih ada {{ $unanswered }} soal yang belum kamu jawab.
                        @elseif ($failed)
                            Kamu butuh minimal {{ $required }} jawaban benar ({{ $level->minScore }}%) untuk menyelesaikan latihan ini.
                            Baca lagi penjelasan di soal yang salah, lalu ulangi latihannya.
                        @else
                            Latihan selesai! Baca lagi penjelasan di soal yang salah supaya makin paham.
                        @endif
                    </p>

                    <ol class="cq-review">
                        @foreach ($review as $item)
                            <li class="cq-review-item is-{{ $item['state'] }}">
                                <a href="{{ $item['url'] }}">
                                    <i @class([
                                        'pixelart-icons-font-check' => $item['state'] === 'correct',
                                        'pixelart-icons-font-close' => $item['state'] === 'wrong',
                                        'pixelart-icons-font-circle' => $item['state'] === 'unanswered',
                                    ]) aria-hidden="true"></i>
                                    <span class="cq-review-number">Soal {{ $item['number'] }}</span>
                                    <span class="cq-review-prompt">{{ $item['type']->label() }}: {{ $item['prompt'] }}</span>
                                    <span class="cq-review-state">
                                        @if ($item['state'] === 'correct')
                                            Benar
                                        @elseif ($item['state'] === 'wrong')
                                            Salah
                                        @else
                                            Belum dijawab
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ol>

                    <div class="cq-study-nav">
                        <form method="POST" action="{{ route('practice.restart', [$language->key, $level->order]) }}">
                            @csrf
                            <button type="submit" @class(['btn', 'btn-primary' => $failed, 'btn-ghost' => ! $failed])>
                                <i class="pixelart-icons-font-reload" aria-hidden="true"></i> Ulangi latihan
                            </button>
                        </form>
                        @if ($nextLevel)
                            <a href="{{ route('paths.show', $language->key) }}" class="btn btn-ghost ms-auto">Jalur belajar</a>
                            <a href="{{ $nextLevelUrl }}" class="btn btn-primary">
                                Lanjut ke Level {{ $nextLevel->order }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                            </a>
                        @else
                            <a href="{{ route('paths.show', $language->key) }}" @class(['btn', 'ms-auto', 'btn-primary' => ! $failed, 'btn-ghost' => $failed])>
                                Kembali ke jalur belajar
                            </a>
                        @endif
                    </div>
                @endif
            </article>
        </div>
    </section>
@endsection
