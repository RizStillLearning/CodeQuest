{{-- @include('partials.level-summary', ['level' => $level]) — title, description, and lesson/question/XP counts. --}}
<div class="cq-level-box">
    <span class="cq-kicker mb-1">Level {{ $level->order }}</span>
    <h4>{{ $level->title }}</h4>
    <p>{{ $level->description }}</p>
    <ul class="cq-stats">
        <li><i class="pixelart-icons-font-book-open" aria-hidden="true"></i> <strong>{{ count($level->lessons) }}</strong> pelajaran</li>
        <li><i class="pixelart-icons-font-circle-question" aria-hidden="true"></i> <strong>{{ count($level->questions) }}</strong> soal</li>
        <li class="is-xp"><i class="pixelart-icons-font-zap" aria-hidden="true"></i> <strong>{{ $level->totalXp() }}</strong> XP</li>
    </ul>
</div>
