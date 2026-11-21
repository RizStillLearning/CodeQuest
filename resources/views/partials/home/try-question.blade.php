{{-- @include('partials.home.try-question', ['question' => $question, 'language' => $language]) — App\Content\Question and App\Content\Language. --}}
{{-- Demo only: the answer is checked in the browser and no XP is saved. --}}
<article class="cq-try" id="coba" aria-labelledby="cq-try-prompt"
         data-try-question
         data-answers='@json($question->acceptedAnswers())'
         data-text-correct="Tepat sekali!"
         data-text-wrong="Belum tepat."
         data-text-empty="Tulis jawabanmu dulu, ya.">
    <header class="cq-try-bar">
        <span>C:\CODEQUEST\COBA_SOAL.EXE</span>
        <span class="cq-chip cq-chip-xp" data-xp-chip>
            <i class="pixelart-icons-font-zap" aria-hidden="true"></i> +{{ $question->xp }} XP
        </span>
    </header>

    <div class="cq-try-body">
        <div>
            <div class="cq-try-head">
                <span class="cq-chip">
                    <i class="pixelart-icons-font-{{ $question->type->icon() }}" aria-hidden="true"></i>
                    {{ $question->type->label() }}
                </span>
                <span class="cq-chip cq-chip-muted">{{ $language->name }}</span>
            </div>
            <p class="cq-try-kicker">Coba sekarang, tanpa daftar</p>
            <h2 class="cq-try-prompt" id="cq-try-prompt">{{ $question->prompt }}</h2>

            @if ($question->scenario)
                <p class="cq-try-scenario">{!! nl2br(e($question->scenario)) !!}</p>
            @endif

            @if ($question->code)
                @include('partials.code-block', ['code' => $question->code, 'fileName' => $language->fileName])
            @endif
        </div>

        <div>
            <form class="cq-try-form" data-try-form novalidate>
                @if ($question->type->hasOptions())
                    <div class="cq-options" role="group" aria-labelledby="cq-try-prompt">
                        @foreach ($question->options as $option)
                            <button type="button" class="cq-option" data-option="{{ $option }}">{{ $option }}</button>
                        @endforeach
                    </div>
                @else
                    <label class="form-label" for="cq-try-answer">Jawabanmu</label>
                    <div class="cq-answer-row">
                        <span class="cq-prompt-symbol" aria-hidden="true">&gt;</span>
                        @if ($question->expectsMultilineAnswer())
                            <textarea id="cq-try-answer" class="cq-terminal-input" data-answer-input
                                      rows="{{ substr_count(trim($question->answer), "\n") + 1 }}"
                                      autocomplete="off" autocapitalize="off" spellcheck="false"
                                      placeholder="Ketik di sini"></textarea>
                        @else
                            <input id="cq-try-answer" type="text" class="cq-terminal-input" data-answer-input
                                   autocomplete="off" autocapitalize="off" spellcheck="false" enterkeyhint="done"
                                   placeholder="Ketik di sini">
                        @endif
                    </div>
                    <button type="submit" class="btn cq-btn-terminal w-100">Cek jawaban</button>
                @endif
            </form>

            <div aria-live="polite">
                <p class="cq-hint" data-hint hidden></p>
                <div class="cq-feedback" data-feedback hidden>
                    <p class="cq-feedback-title">
                        <i class="pixelart-icons-font-check cq-icon-correct" aria-hidden="true"></i>
                        <i class="pixelart-icons-font-close cq-icon-wrong" aria-hidden="true"></i>
                        <span data-feedback-title></span>
                    </p>
                    <p class="mb-0">{{ $question->explanation }}</p>
                </div>
            </div>

            <div class="cq-try-next" data-next hidden>
                <p class="mb-0">Daftar untuk lanjut ke soal berikutnya dan mulai mengumpulkan XP.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Daftar &amp; lanjutkan <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</article>
