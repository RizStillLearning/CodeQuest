@extends('errors.layout')

@section('code', '429')
@section('icon', 'hourglass-split')
@section('title', 'Terlalu banyak percobaan')
@section('message', 'Tunggu sekitar satu menit, lalu coba lagi.')
@section('retry', true)
