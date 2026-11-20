{{-- Shown in the hero when the demo question can't be loaded. --}}
<div class="cq-hero-art" aria-hidden="true">
    @include('partials.logo', ['class' => 'cq-logo-xl'])
    <div class="cq-hero-art-chips">
        <span class="cq-chip cq-chip-success"><i class="bi bi-check-circle-fill"></i> Level 1</span>
        <span class="cq-chip cq-chip-xp"><i class="bi bi-lightning-charge-fill"></i> +20 XP</span>
        <span class="cq-chip cq-chip-muted"><i class="bi bi-lock-fill"></i> Level 2</span>
    </div>
</div>
