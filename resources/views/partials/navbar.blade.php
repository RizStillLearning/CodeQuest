{{-- Guests see the landing-page sections; signed-in learners see the app's features. --}}
<nav class="navbar navbar-expand-lg sticky-top cq-navbar" aria-label="Navigasi utama">
    <div class="container">
        @auth
            <a class="navbar-brand" href="{{ route('learn') }}" aria-label="CodeQuest, ke halaman belajar">
                @include('partials.logo')
            </a>
        @else
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="CodeQuest, ke beranda">
                @include('partials.logo')
            </a>
        @endauth

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#cq-main-nav"
                aria-controls="cq-main-nav" aria-expanded="false" aria-label="Buka menu">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="cq-main-nav">
            @auth
                <ul class="navbar-nav mx-lg-auto cq-app-nav">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('learn')]) href="{{ route('learn') }}"
                           @if (request()->routeIs('learn')) aria-current="page" @endif>
                            <i class="bi bi-journal-code" aria-hidden="true"></i> Belajar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('progress')]) href="{{ route('progress') }}"
                           @if (request()->routeIs('progress')) aria-current="page" @endif>
                            <i class="bi bi-graph-up-arrow" aria-hidden="true"></i> Progres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('leaderboard')]) href="{{ route('leaderboard') }}"
                           @if (request()->routeIs('leaderboard')) aria-current="page" @endif>
                            <i class="bi bi-trophy" aria-hidden="true"></i> Peringkat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('forum')]) href="{{ route('forum') }}"
                           @if (request()->routeIs('forum')) aria-current="page" @endif>
                            <i class="bi bi-chat-dots" aria-hidden="true"></i> Diskusi
                        </a>
                    </li>
                </ul>
                <div class="cq-navbar-actions">
                    <div class="dropdown">
                        <button class="cq-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="cq-avatar" aria-hidden="true">{{ auth()->user()->initial() }}</span>
                            <span>{{ auth()->user()->firstName() }}</span>
                            <span class="visually-hidden">, buka menu akun</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end cq-user-menu">
                            <li class="cq-user-menu-head">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <ul class="navbar-nav mx-lg-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#bahasa">Bahasa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#cara-kerja">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#jenis-soal">Jenis Soal</a></li>
                </ul>
                <div class="cq-navbar-actions">
                    <a class="btn btn-ghost" href="{{ route('login') }}">Masuk</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
