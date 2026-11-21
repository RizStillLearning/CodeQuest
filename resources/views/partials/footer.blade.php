<footer class="cq-footer">
    <div class="container">
        <div class="cq-footer-inner">
            <div class="d-flex align-items-center gap-3 flex-wrap justify-content-center">
                @include('partials.logo', ['class' => 'cq-logo-sm'])
                <span>Belajar coding lewat praktik.</span>
            </div>
            <nav aria-label="Navigasi footer">
                <ul class="cq-footer-links">
                    @auth
                        <li><a href="{{ route('learn') }}"><i class="pixelart-icons-font-book-open" aria-hidden="true"></i> Belajar</a></li>
                        <li><a href="{{ route('progress') }}"><i class="pixelart-icons-font-trending-up" aria-hidden="true"></i> Progres</a></li>
                        <li><a href="{{ route('leaderboard') }}"><i class="pixelart-icons-font-trophy" aria-hidden="true"></i> Peringkat</a></li>
                        <li><a href="{{ route('forum') }}"><i class="pixelart-icons-font-message" aria-hidden="true"></i> Diskusi</a></li>
                    @else
                        <li><a href="{{ route('home') }}#bahasa"><i class="pixelart-icons-font-code" aria-hidden="true"></i> Bahasa</a></li>
                        <li><a href="{{ route('home') }}#cara-kerja"><i class="pixelart-icons-font-road-sign" aria-hidden="true"></i> Cara Kerja</a></li>
                        <li><a href="{{ route('home') }}#jenis-soal"><i class="pixelart-icons-font-circle-question" aria-hidden="true"></i> Jenis Soal</a></li>
                    @endauth
                </ul>
            </nav>
            <p class="cq-footer-copy">&copy; {{ date('Y') }} CodeQuest</p>
        </div>
    </div>
</footer>
