{{-- Shown instead of the languages when content/ can't be loaded. No variables. --}}
<div class="cq-notice" role="status">
    <i class="pixelart-icons-font-warning-diamond" aria-hidden="true"></i>
    <div>
        <p class="fw-bold mb-1">Daftar bahasa belum bisa dimuat.</p>
        <p class="mb-3">Coba muat ulang halaman ini sebentar lagi.</p>
        <a href="{{ url()->current() }}" class="btn btn-primary btn-sm">
            <i class="pixelart-icons-font-reload" aria-hidden="true"></i> Muat ulang
        </a>
    </div>
</div>
