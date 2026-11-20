<footer class="cq-footer">
    <div class="container">
        <div class="cq-footer-inner">
            <div class="d-flex align-items-center gap-3 flex-wrap justify-content-center">
                @include('partials.logo', ['class' => 'cq-logo-sm'])
                <span class="text-body-secondary small">Belajar coding lewat praktik.</span>
            </div>
            <nav aria-label="Navigasi footer">
                <ul class="cq-footer-links">
                    @auth
                        <li><a href="{{ route('learn') }}">Belajar</a></li>
                        <li><a href="{{ route('progress') }}">Progres</a></li>
                        <li><a href="{{ route('leaderboard') }}">Peringkat</a></li>
                        <li><a href="{{ route('forum') }}">Diskusi</a></li>
                    @else
                        <li><a href="{{ route('home') }}#bahasa">Bahasa</a></li>
                        <li><a href="{{ route('home') }}#cara-kerja">Cara Kerja</a></li>
                        <li><a href="{{ route('home') }}#jenis-soal">Jenis Soal</a></li>
                    @endauth
                </ul>
            </nav>
            <p class="small text-body-secondary mb-0">&copy; {{ date('Y') }} CodeQuest</p>
        </div>
    </div>
</footer>
