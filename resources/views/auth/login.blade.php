@extends('layouts.auth')

@section('title', 'Masuk · CodeQuest')
@section('heading', 'Masuk ke CodeQuest')
@section('subheading', 'Lanjutkan quest belajarmu dari terakhir kali.')

@section('form')
    <form method="POST" action="{{ route('login') }}" data-submit-once novalidate>
        @csrf

        @include('partials.form-input', [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'autocomplete' => 'email',
            'inputmode' => 'email',
            'plainText' => true,
        ])

        @include('partials.form-input', [
            'name' => 'password',
            'type' => 'password',
            'label' => 'Kata sandi',
            'autocomplete' => 'current-password',
            'revealable' => true,
        ])

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="field-remember" value="1" @checked(old('remember'))>
            <label class="form-check-label" for="field-remember">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100" data-loading-text="Memproses…">Masuk</button>
    </form>

    <p class="cq-auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
@endsection
