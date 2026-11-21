{{--
    Top of lesson and practice pages.

    @include('partials.level-header', [
        'language' => $language,     App\Content\Language
        'level' => $level,           App\Content\Level
        'label' => 'Soal 3 dari 10', where the learner is
        'progress' => 30,            0-100
    ])
--}}
<div class="cq-level-header">
    <a href="{{ route('levels.show', [$language->key, $level->order]) }}" class="cq-back-link">
        <i class="pixelart-icons-font-arrow-left" aria-hidden="true"></i> Materi level {{ $level->order }}
    </a>
    <div class="cq-level-header-main">
        <span class="cq-lang-badge cq-lang-{{ $language->key }}" aria-hidden="true">.{{ $language->extension() }}</span>
        <div class="cq-level-header-text">
            <span class="cq-level-header-kicker">{{ $language->name }} · Level {{ $level->order }}</span>
            <span class="cq-level-header-title">{{ $level->title }}</span>
        </div>
        <span class="cq-level-header-label">{{ $label }}</span>
    </div>
    <div class="progress cq-progress" role="progressbar" aria-label="{{ $label }}"
         aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: {{ $progress }}%"></div>
    </div>
</div>
