{{-- @include('partials.learning-path', ['path' => $path]) — $path is an App\ViewModels\LearningPath built by the controller. --}}
<div class="cq-path" style="--path-shift: {{ \App\ViewModels\LearningPath::SHIFT_PERCENT }}%">
    <svg class="cq-path-line" viewBox="0 0 100 {{ count($path->steps) * 100 }}" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="{{ $path->line }}" />
    </svg>
    <ol class="cq-path-list">
        @foreach ($path->steps as $step)
            <li class="cq-path-step {{ $step['open'] ? 'is-open' : 'is-locked' }}" style="--shift: {{ $step['shift'] }}">
                <span class="cq-path-node" aria-hidden="true">
                    <i class="bi bi-{{ $step['open'] ? 'play-fill' : 'lock-fill' }}"></i>
                </span>
                <span class="cq-path-label">
                    <span class="cq-path-kind">
                        {{ $step['kind'] }}
                        @if ($step['open'])
                            <span class="cq-path-start">Mulai di sini</span>
                        @else
                            <span class="visually-hidden">(terkunci)</span>
                        @endif
                    </span>
                    <span class="cq-path-title">{{ $step['title'] }}</span>
                    <span class="cq-path-meta">{{ $step['meta'] }}</span>
                </span>
            </li>
        @endforeach
    </ol>
</div>
