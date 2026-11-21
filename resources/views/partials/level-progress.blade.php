{{--
    A level's progress bar and its Mulai / Lanjutkan / Ulangi button.

    @include('partials.level-progress', [
        'level' => $level,          App\Content\Level
        'progress' => $progress,    one entry of App\ViewModels\LearningPath::$levelProgress
    ])
--}}
<div class="cq-level-progress">
    <span>
        @if ($progress['finished'])
            <i class="pixelart-icons-font-check" aria-hidden="true"></i> Level selesai
        @else
            {{ $progress['done'] }} dari {{ $progress['total'] }} langkah selesai
        @endif
    </span>
    <div class="progress cq-progress" role="progressbar" aria-label="Progres Level {{ $level->order }}"
         aria-valuenow="{{ $progress['percent'] }}" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: {{ $progress['percent'] }}%"></div>
    </div>
</div>
@if ($progress['locked'])
    <span class="btn w-100 btn-ghost disabled" aria-disabled="true">
        <i class="pixelart-icons-font-lock" aria-hidden="true"></i> Level {{ $level->order }} terkunci
    </span>
    <p class="cq-locked-hint">Selesaikan level sebelumnya untuk membukanya.</p>
@else
    <a href="{{ $progress['url'] }}" @class(['btn', 'w-100', 'btn-primary' => $progress['next'], 'btn-ghost' => ! $progress['next']])>
        {{ $progress['action'] }} Level {{ $level->order }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
    </a>
@endif
