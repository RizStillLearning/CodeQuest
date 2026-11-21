{{-- @include('partials.learning-path', ['path' => $path]) — $path is an App\ViewModels\LearningPath built by the controller. --}}
<div class="cq-path" style="--path-shift: {{ \App\ViewModels\LearningPath::SHIFT_PERCENT }}%">
    <svg class="cq-path-line" viewBox="0 0 100 {{ count($path->steps) * 100 }}" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="{{ $path->line }}" />
        @if ($path->progressLine)
            <path class="is-progress" d="{{ $path->progressLine }}" />
        @endif
    </svg>
    <ol class="cq-path-list">
        @foreach ($path->steps as $step)
            <li @class([
                'cq-path-step',
                'is-'.$step['type'],
                'is-open' => $step['url'],
                'is-done' => $step['done'],
                'is-locked' => $step['locked'],
                'is-current' => $step['current'],
            ]) style="--shift: {{ $step['shift'] }}">
                @if ($step['url'])
                    <a class="cq-path-link" href="{{ $step['url'] }}">
                @else
                    <div class="cq-path-link">
                @endif
                    <span class="cq-path-node" aria-hidden="true"><i class="pixelart-icons-font-{{ $step['icon'] }}"></i></span>
                    <span class="cq-path-label">
                        <span class="cq-path-kind">
                            {{ $step['kind'] }}
                            @if ($step['badge'])
                                <span class="cq-path-start">{{ $step['badge'] }}</span>
                            @endif
                            @if ($step['done'])
                                <span class="visually-hidden">(selesai)</span>
                            @elseif ($step['locked'])
                                <span class="visually-hidden">(terkunci)</span>
                            @endif
                        </span>
                        <span class="cq-path-title">{{ $step['title'] }}</span>
                        <span class="cq-path-meta">{{ $step['meta'] }}</span>
                    </span>
                @if ($step['url'])
                    </a>
                @else
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</div>
