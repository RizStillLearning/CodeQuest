{{--
    Language tabs, each with a level card and the level's learning path.
    Used on the homepage (guests) and on /belajar (signed-in learners).

    @include('partials.language-tracks', [
        'tracks' => $tracks,       list of App\Content\Track
        'paths' => $paths,         App\ViewModels\LearningPath per language key
        'startUrl' => $url,        where the start button goes; null shows it as not available yet
    ])
--}}

@if ($tracks === [])
    <div class="cq-notice" role="status">
        <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
        <div>
            <p class="fw-bold mb-1">Daftar bahasa belum bisa dimuat.</p>
            <p class="mb-3">Coba muat ulang halaman ini sebentar lagi.</p>
            <a href="{{ url()->current() }}" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-clockwise" aria-hidden="true"></i> Muat ulang
            </a>
        </div>
    </div>
@else
    <ul class="nav cq-lang-tabs" role="tablist">
        @foreach ($tracks as $track)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="cq-tab-{{ $track->language->key }}"
                        type="button" role="tab" data-bs-toggle="pill" data-bs-target="#cq-pane-{{ $track->language->key }}"
                        aria-controls="cq-pane-{{ $track->language->key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    <span class="cq-ext" aria-hidden="true">.{{ $track->language->extension() }}</span>
                    {{ $track->language->name }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach ($tracks as $track)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="cq-pane-{{ $track->language->key }}"
                 role="tabpanel" aria-labelledby="cq-tab-{{ $track->language->key }}" tabindex="0">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="cq-lang-card">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <span class="cq-lang-badge cq-lang-{{ $track->language->key }}" aria-hidden="true">.{{ $track->language->extension() }}</span>
                                <div>
                                    <h3 class="h4 mb-0">{{ $track->language->name }}</h3>
                                    <p class="small text-body-secondary mb-0">{{ count($track->language->levels) }} level tersedia</p>
                                </div>
                            </div>
                            <p class="text-body-secondary">{{ $track->language->tagline }}</p>

                            <div class="cq-level-box">
                                <span class="cq-kicker mb-1">Level {{ $track->level->order }}</span>
                                <h4>{{ $track->level->title }}</h4>
                                <p>{{ $track->level->description }}</p>
                                <ul class="cq-stats">
                                    <li><i class="bi bi-book-half" aria-hidden="true"></i> <strong>{{ count($track->level->lessons) }}</strong> pelajaran</li>
                                    <li><i class="bi bi-patch-question-fill" aria-hidden="true"></i> <strong>{{ count($track->level->questions) }}</strong> soal</li>
                                    <li class="is-xp"><i class="bi bi-lightning-charge-fill" aria-hidden="true"></i> <strong>{{ $track->level->totalXp() }}</strong> XP</li>
                                </ul>
                            </div>

                            @if ($startUrl ?? null)
                                <a href="{{ $startUrl }}" class="btn btn-primary w-100">
                                    Mulai belajar {{ $track->language->name }} <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            @else
                                <button type="button" class="btn btn-primary w-100" disabled aria-describedby="cq-start-note-{{ $track->language->key }}">
                                    Mulai belajar {{ $track->language->name }} <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </button>
                                <p class="cq-start-note" id="cq-start-note-{{ $track->language->key }}">
                                    <i class="bi bi-hourglass-split" aria-hidden="true"></i> Halaman pelajaran sedang kami siapkan.
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="cq-path-panel">
                            <div class="cq-path-panel-head">
                                <div>
                                    <span class="cq-kicker mb-0">Jalur belajar</span>
                                    <h4 class="mb-0">Level {{ $track->level->order }}: {{ $track->level->title }}</h4>
                                </div>
                                <ul class="cq-legend" aria-label="Keterangan">
                                    <li><span class="cq-legend-dot is-open" aria-hidden="true"></span> Terbuka</li>
                                    <li><span class="cq-legend-dot is-locked" aria-hidden="true"></span> Terkunci</li>
                                </ul>
                            </div>
                            @include('partials.learning-path', ['path' => $paths[$track->language->key]])
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
