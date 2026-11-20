{{-- @include('partials.home.try-question', ['question' => $question, 'language' => $language]) — App\Content\Question and App\Content\Language. --}}
<div class="cq-try-wrap">
    {{-- Demo only: the answer is checked in the browser and no XP is saved. --}}
    <article class="cq-try" id="coba" aria-labelledby="cq-try-prompt"
             data-try-question
             data-answers='@json($question->acceptedAnswers())'
             data-text-correct="Tepat sekali!"
             data-text-wrong="Belum tepat."
             data-text-empty="Tulis jawabanmu dulu, ya.">
        <header class="cq-try-head">
            <span class="cq-chip">
                <i class="bi bi-{{ $question->type->icon() }}" aria-hidden="true"></i>
                {{ $question->type->label() }}
            </span>
            <span class="cq-chip cq-chip-muted">{{ $language->name }}</span>
            <span class="cq-chip cq-chip-xp ms-auto" data-xp-chip>
                <i class="bi bi-lightning-charge-fill" aria-hidden="true"></i>
                +{{ $question->xp }} XP
            </span>
        </header>

        <p class="cq-try-kicker">Coba sekarang, tanpa daftar</p>
        <h2 class="cq-try-prompt" id="cq-try-prompt">{{ $question->prompt }}</h2>

        @if ($question->scenario)
            <p class="cq-try-scenario">{!! nl2br(e($question->scenario)) !!}</p>
        @endif

        @if ($question->code)
            @include('partials.code-block', ['code' => $question->code, 'fileName' => $language->fileName])
        @endif

        <form class="cq-try-form" data-try-form novalidate>
            @if ($question->type->hasOptions())
                <div class="cq-options" role="group" aria-labelledby="cq-try-prompt">
                    @foreach ($question->options as $option)
                        <button type="button" class="cq-option" data-option="{{ $option }}">{{ $option }}</button>
                    @endforeach
                </div>
            @else
                <label class="form-label fw-semibold" for="cq-try-answer">Jawabanmu</label>
                <div class="cq-answer-row">
                    @if ($question->expectsMultilineAnswer())
                        <textarea id="cq-try-answer" class="form-control cq-input-code" data-answer-input
                                  rows="{{ substr_count(trim($question->answer), "\n") + 1 }}"
                                  autocomplete="off" autocapitalize="off" spellcheck="false"
                                  placeholder="Ketik di sini"></textarea>
                    @else
                        <input id="cq-try-answer" type="text" class="form-control cq-input-code" data-answer-input
                               autocomplete="off" autocapitalize="off" spellcheck="false" enterkeyhint="done"
                               placeholder="Ketik di sini">
                    @endif
                    <button type="submit" class="btn btn-primary">Cek jawaban</button>
                </div>
            @endif
        </form>

        <div aria-live="polite">
            <p class="cq-hint" data-hint hidden></p>
            <div class="cq-feedback" data-feedback hidden>
                <p class="cq-feedback-title">
                    <i class="bi bi-check-circle-fill cq-icon-correct" aria-hidden="true"></i>
                    <i class="bi bi-x-circle-fill cq-icon-wrong" aria-hidden="true"></i>
                    <span data-feedback-title></span>
                </p>
                <p class="mb-0">{{ $question->explanation }}</p>
            </div>
        </div>

        <div class="cq-try-next" data-next hidden>
            <p class="mb-0">Daftar untuk lanjut ke soal berikutnya dan mulai mengumpulkan XP.</p>
            <a href="{{ route('register') }}" class="btn btn-xp btn-sm">
                Daftar &amp; lanjutkan <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </article>

    <div class="cq-float-badge" aria-hidden="true">
        <i class="bi bi-check-circle-fill"></i> Feedback instan
    </div>
</div>
