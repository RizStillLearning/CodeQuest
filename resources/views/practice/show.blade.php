{{-- Data comes from PracticeController@show. $attempt is the saved App\Models\Answer, or null until the question is answered. --}}
@extends('layouts.app')

@section('title', 'Latihan soal · CodeQuest')

@section('content')
    <section class="cq-page cq-study">
        <div class="container cq-study-container">
            @include('partials.level-header', ['language' => $language, 'level' => $level, 'label' => $progressLabel, 'progress' => $progress])

            <article class="cq-study-card" aria-labelledby="cq-question-prompt">
                <span class="cq-chip mb-3">
                    <i class="pixelart-icons-font-{{ $question->type->icon() }}" aria-hidden="true"></i> {{ $question->type->label() }}
                </span>

                @if ($question->scenario)
                    <p class="cq-question-scenario">{!! nl2br(e($question->scenario)) !!}</p>
                @endif

                <h1 class="cq-study-title" id="cq-question-prompt">{{ $question->prompt }}</h1>

                @if ($question->code)
                    @include('partials.code-block', ['code' => $question->code, 'fileName' => $language->fileName, 'input' => $question->input])
                @endif

                @if ($attempt === null)
                    <form method="POST" action="{{ route('practice.answer', [$language->key, $level->order, $number]) }}" data-submit-once novalidate>
                        @csrf

                        @if ($question->type->hasOptions())
                            <fieldset class="cq-choices" @error('answer') aria-describedby="answer-error" @enderror>
                                <legend class="visually-hidden">Pilih jawaban</legend>
                                @foreach ($question->options as $option)
                                    <label class="cq-choice">
                                        <input type="radio" name="answer" value="{{ $option }}" @checked(old('answer') === $option)>
                                        <span>{{ $option }}</span>
                                    </label>
                                @endforeach
                            </fieldset>
                        @else
                            <label class="form-label fw-semibold" for="answer">Jawabanmu</label>
                            @if ($question->expectsMultilineAnswer())
                                <textarea id="answer" name="answer" rows="{{ substr_count(trim($question->answer), "\n") + 1 }}"
                                          @class(['form-control', 'cq-input-code', 'is-invalid' => $errors->has('answer')])
                                          autocomplete="off" autocapitalize="off" spellcheck="false"
                                          @error('answer') aria-describedby="answer-error" @enderror>{{ old('answer') }}</textarea>
                            @else
                                <input id="answer" name="answer" type="text" value="{{ old('answer') }}"
                                       @class(['form-control', 'cq-input-code', 'is-invalid' => $errors->has('answer')])
                                       autocomplete="off" autocapitalize="off" spellcheck="false"
                                       @error('answer') aria-describedby="answer-error" @enderror>
                            @endif
                        @endif

                        @error('answer')
                            <p class="invalid-feedback d-block" id="answer-error">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-lg mt-3" data-loading-text="Memeriksa…">Cek jawaban</button>
                    </form>
                @else
                    @if ($question->type->hasOptions())
                        <ul class="cq-choices">
                            @foreach ($question->options as $option)
                                <li @class([
                                    'cq-choice',
                                    'is-correct' => $option === $question->answer,
                                    'is-wrong' => $option === $attempt->answer && ! $attempt->correct,
                                ])>
                                    <span>{{ $option }}</span>
                                    @if ($option === $attempt->answer)
                                        <span class="cq-choice-tag">Jawabanmu</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="cq-answer-label">Jawabanmu</p>
                        <pre @class(['cq-answer', 'is-correct' => $attempt->correct, 'is-wrong' => ! $attempt->correct])>{{ $attempt->answer }}</pre>
                        @unless ($attempt->correct)
                            <p class="cq-answer-label">Jawaban yang benar</p>
                            <pre class="cq-answer is-correct">{{ $question->answer }}</pre>
                        @endunless
                    @endif

                    <div @class(['cq-feedback', 'is-correct' => $attempt->correct, 'is-wrong' => ! $attempt->correct]) tabindex="-1" data-autofocus>
                        <p class="cq-feedback-title">
                            @if ($attempt->correct)
                                <i class="pixelart-icons-font-check" aria-hidden="true"></i> Tepat sekali!
                            @else
                                <i class="pixelart-icons-font-close" aria-hidden="true"></i> Belum tepat.
                            @endif
                        </p>
                        <p class="mb-0">{{ $question->explanation }}</p>
                    </div>

                    <div class="cq-study-nav">
                        <a href="{{ $nextUrl }}" class="btn btn-primary btn-lg ms-auto">
                            {{ $nextLabel }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                @endif
            </article>
        </div>
    </section>
@endsection
