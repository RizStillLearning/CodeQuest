{{-- @include('partials.code-block', ['code' => $code, 'fileName' => 'main.py', 'input' => '7']) — $input (what the user types) is optional. --}}
<figure class="cq-code">
    <figcaption class="cq-code-bar">
        <span class="cq-code-dots" aria-hidden="true"><span></span><span></span><span></span></span>
        <span class="cq-code-file">{{ $fileName }}</span>
    </figcaption>
    {{-- Each line is escaped first; only the ____ blank of fill-in questions gets markup. --}}
    <pre tabindex="0" aria-label="Contoh kode"><code>@foreach (preg_split('/\R/', rtrim($code)) as $line)<span class="cq-code-line">{!! str_replace('____', '<mark class="cq-blank">____</mark>', e($line)) !!}</span>@endforeach</code></pre>
    @isset($input)
        <div class="cq-code-input">
            <span class="cq-code-input-label">Input pengguna</span>
            <kbd class="cq-code-input-value">{{ $input }}</kbd>
        </div>
    @endisset
</figure>
