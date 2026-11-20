{{-- @include('partials.logo', ['class' => 'cq-logo-sm']) — $class is optional. --}}
<span class="cq-logo {{ $class ?? '' }}">
    <svg class="cq-logo-mark" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        <rect width="32" height="32" rx="9" fill="currentColor" />
        <path d="M11.5 10.5 6.5 16l5 5.5M20.5 10.5l5 5.5-5 5.5" fill="none" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M17.6 8.5 14.4 23.5" fill="none" stroke="#ffc24b" stroke-width="2.6" stroke-linecap="round" />
    </svg>
    <span class="cq-logo-word">Code<span>Quest</span></span>
</span>
