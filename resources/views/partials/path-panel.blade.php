{{-- @include('partials.path-panel', ['path' => $path, 'title' => 'Jalur belajar']) — $path is an App\ViewModels\LearningPath. --}}
<div class="cq-path-panel">
    <div class="cq-path-panel-head">
        <span class="cq-kicker mb-0">{{ $title }}</span>
        <ul class="cq-legend" aria-label="Keterangan">
            <li><span class="cq-legend-dot is-done" aria-hidden="true"></span> Selesai</li>
            <li><span class="cq-legend-dot is-open" aria-hidden="true"></span> Terbuka</li>
            <li><span class="cq-legend-dot is-locked" aria-hidden="true"></span> Terkunci</li>
        </ul>
    </div>
    @include('partials.learning-path', ['path' => $path])
</div>
