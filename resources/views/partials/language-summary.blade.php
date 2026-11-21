{{-- @include('partials.language-summary', ['language' => $language]) — badge, name, level count, and tagline. --}}
<div class="d-flex align-items-center gap-3 mb-3">
    <span class="cq-lang-badge cq-lang-{{ $language->key }}" aria-hidden="true">.{{ $language->extension() }}</span>
    <div>
        <h3 class="h4 mb-0">{{ $language->name }}</h3>
        <p class="small text-body-secondary mb-0">{{ count($language->levels) }} level tersedia</p>
    </div>
</div>
<p class="text-body-secondary">{{ $language->tagline }}</p>
