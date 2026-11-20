@extends('layouts.auth')

@section('title', 'Daftar · CodeQuest')
@section('heading', 'Buat akun CodeQuest')
@section('subheading', 'Mulai dari nol. Daftar cukup satu menit.')

@section('form')
    <form method="POST" action="{{ route('register') }}" data-submit-once novalidate>
        @csrf

        @include('partials.form-input', [
            'name' => 'name',
            'label' => 'Nama',
            'autocomplete' => 'name',
            'maxlength' => 100,
        ])

        @include('partials.form-input', [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'autocomplete' => 'email',
            'inputmode' => 'email',
            'maxlength' => 255,
            'plainText' => true,
        ])

        @include('partials.form-input', [
            'name' => 'password',
            'type' => 'password',
            'label' => 'Kata sandi',
            'hint' => 'Minimal 8 karakter.',
            'autocomplete' => 'new-password',
            'minlength' => 8,
            'maxlength' => 72,
            'revealable' => true,
        ])

        @include('partials.form-input', [
            'name' => 'password_confirmation',
            'type' => 'password',
            'label' => 'Ulangi kata sandi',
            'autocomplete' => 'new-password',
            'maxlength' => 72,
            'revealable' => true,
        ])

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-2" data-loading-text="Membuat akun…">Buat akun</button>
    </form>

    <p class="cq-auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection
