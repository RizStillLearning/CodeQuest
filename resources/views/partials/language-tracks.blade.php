{{--
    Homepage preview: language tabs, each with a level card and the level's learning path.

    @include('partials.language-tracks', [
        'paths' => $paths,         list of App\ViewModels\LearningPath, one per language
        'startUrl' => $url,        where the start buttons go
    ])
--}}

@if ($paths === [])
    @include('partials.content-notice')
@else
    <ul class="nav cq-lang-tabs" role="tablist">
        @foreach ($paths as $path)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="cq-tab-{{ $path->language->key }}"
                        type="button" role="tab" data-bs-toggle="pill" data-bs-target="#cq-pane-{{ $path->language->key }}"
                        aria-controls="cq-pane-{{ $path->language->key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    <span class="cq-ext" aria-hidden="true">.{{ $path->language->extension() }}</span>
                    {{ $path->language->name }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach ($paths as $path)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="cq-pane-{{ $path->language->key }}"
                 role="tabpanel" aria-labelledby="cq-tab-{{ $path->language->key }}" tabindex="0">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="cq-lang-card">
                            @include('partials.language-summary', ['language' => $path->language])
                            @include('partials.level-summary', ['level' => $path->levels[0]])
                            <a href="{{ $startUrl }}" class="btn btn-primary w-100">
                                Mulai belajar {{ $path->language->name }} <i class="pixelart-icons-font-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        @include('partials.path-panel', ['path' => $path, 'title' => 'Materi level 1'])
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
