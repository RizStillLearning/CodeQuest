{{-- @include('partials.code-block', ['code' => $code, 'fileName' => 'main.py']) — $fileName is optional. --}}
<figure class="cq-code">
    @isset($fileName)
        <figcaption class="cq-code-bar">
            <span class="cq-code-dots" aria-hidden="true"><span></span><span></span><span></span></span>
            <span class="cq-code-file">{{ $fileName }}</span>
        </figcaption>
    @endisset
    <pre tabindex="0" aria-label="Contoh kode"><code>@foreach (preg_split('/\R/', rtrim($code)) as $line)<span class="cq-code-line">{{ $line }}</span>@endforeach</code></pre>
</figure>
